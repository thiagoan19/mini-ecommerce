<script setup>
import { computed } from 'vue'
import { useCartStore } from '@/stores/cart'
import { useToast } from 'vue-toastification'

const cart = useCartStore()
const toast = useToast()

const totalPrice = computed(() => {
  return cart.items.reduce((sum, item) => {
    const price = Number(item.price)
    const quantity = item.quantity || 0
    return sum + (isNaN(price) ? 0 : price * quantity)
  }, 0)
})

function removeItem(id) {
  cart.removeProduct(id)
  toast.info('Produto removido do carrinho')
}

function updateQty(id, quantity) {
  cart.updateQuantity(id, quantity)
  toast.info('Quantidade atualizada')
}

function clear() {
  cart.clearCart()
  toast('Carrinho limpo', { type: 'warning' })
}
</script>

<template>
  <div class="cart-container">
    <h1>Carrinho de Compras 🛒</h1>

    <div v-if="cart.items.length === 0" class="empty">
      Seu carrinho está vazio.
    </div>

    <div v-else>
      <div class="cart-item" v-for="item in cart.items" :key="item.id">
        <img :src="item.image_url" alt="Imagem" class="item-img" />
        <div class="item-info">
          <h2>{{ item.name }}</h2>
          <p>Preço: R$ {{ Number(item.price).toFixed(2) }}</p>
          <label>
            Quantidade:
            <input
              type="number"
              min="1"
              v-model.number="item.quantity"
              @change="updateQty(item.id, item.quantity)"
            />
          </label>
          <button @click="removeItem(item.id)">Remover</button>
        </div>
      </div>

      <div class="total">
        <p>Total: <strong>R$ {{ totalPrice.toFixed(2) }}</strong></p>
        <button @click="clear" class="clear">Limpar carrinho</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.cart-container {
  max-width: 800px;
  margin: auto;
  padding: 1rem;
}
.cart-item {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
  border-bottom: 1px solid #ccc;
  padding-bottom: 1rem;
}
.item-img {
  width: 100px;
  height: auto;
  border-radius: 8px;
}
.item-info {
  flex: 1;
}
.item-info input {
  width: 60px;
  margin-left: 0.5rem;
}
.total {
  text-align: right;
  margin-top: 1rem;
}
.clear {
  margin-top: 0.5rem;
  background-color: crimson;
  color: white;
  padding: 0.4rem 1rem;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}
.empty {
  text-align: center;
  padding: 2rem;
  color: #666;
}
</style>
