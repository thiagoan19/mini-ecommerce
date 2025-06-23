<template>
  <div>
    <header class="header">
      <nav>
        <NuxtLink to="/">Home</NuxtLink>
        <NuxtLink to="/cart" class="cart-link">
          Carrinho ({{ totalQuantity }})
        </NuxtLink>
      </nav>
    </header>

    <main>
      <NuxtPage />
    </main>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useCartStore } from '@/stores/cart'

const cart = useCartStore()

const totalQuantity = computed(() =>
  cart.items.reduce((sum, item) => sum + (item.quantity || 0), 0)
)
</script>

<style scoped>
.header {
  background-color: #3490dc;
  padding: 1rem;
  color: white;
  font-weight: bold;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
nav a {
  color: white;
  margin-right: 1rem;
  text-decoration: none;
}
.cart-link {
  font-weight: bold;
}
</style>
