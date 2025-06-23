<template>
  <div v-if="pending">Carregando produto...</div>
  <div v-else-if="error">Erro ao carregar produto.</div>
  <div v-else class="product-detail-container">
    <div class="product-detail-image">
      <img :src="product.image_url" :alt="product.title" />
    </div>

    <div class="product-detail-info">
      <h1 class="product-name">{{ product.name }}</h1>
      <p class="product-price">R$ {{ Number(product.price).toFixed(2) }}</p>
      <p class="category">Categoria: {{ product.category }}</p>
      <p class="description">{{ product.description }}</p>

      <div class="actions">
        <input
          type="number"
          v-model.number="quantity"
          min="1"
          placeholder="Qtd"
        />
        <button @click="addToCart">Adicionar ao Carrinho</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { useCartStore } from '@/stores/cart'
import { useToast } from 'vue-toastification'

const route = useRoute()
const cart = useCartStore()
const toast = useToast()

const quantity = ref(1)

const { data: product, pending, error } = await useFetch(
  `http://127.0.0.1:8000/api/products/${route.params.id}`
)

function addToCart() {
  if (!product.value) return

  cart.addProduct({
    id: product.value.id,
    name: product.value.title,
    price: Number(product.value.price),
    quantity: quantity.value,
    image_url: product.value.image_url,
  })

  toast.success('Produto adicionado ao carrinho!')
}
</script>

<style scoped>
.product-detail-container {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  padding: 2rem;
}

.product-detail-image img {
  max-width: 100%;
  width: 300px;
  border-radius: 8px;
}

.product-detail-info {
  flex: 1;
  max-width: 500px;
}

.product-detail-info h1 {
  font-size: 2rem;
  margin-bottom: 1rem;
}

.product-detail-info .price {
  font-size: 1.5rem;
  font-weight: bold;
  color: #3490dc;
  margin-bottom: 0.5rem;
}

.product-detail-info .category {
  font-style: italic;
  margin-bottom: 1rem;
}

.product-detail-info .description {
  margin-bottom: 2rem;
  line-height: 1.5;
}

.actions {
  display: flex;
  gap: 1rem;
  align-items: center;
}

.actions input[type="number"] {
  width: 80px;
  padding: 0.4rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.actions button {
  background-color: #38b000;
  color: white;
  border: none;
  padding: 0.6rem 1.2rem;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.actions button:hover {
  background-color: #2d8600;
}

/* Responsivo */
@media (max-width: 768px) {
  .product-detail-container {
    flex-direction: column;
    align-items: center;
  }

  .product-detail-image img {
    width: 100%;
    max-width: 300px;
  }

  .product-detail-info {
    max-width: 100%;
    text-align: center;
  }

  .actions {
    flex-direction: column;
  }

  .actions input[type="number"] {
    width: 100px;
  }
}
</style>

