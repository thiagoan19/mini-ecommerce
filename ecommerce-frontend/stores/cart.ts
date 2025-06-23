import { defineStore } from 'pinia'
import { ref, watch, onMounted } from 'vue'

type CartItem = {
  id: number
  name: string
  price: number
  quantity: number
  image_url: string
}

export const useCartStore = defineStore('cart', () => {
  const items = ref<CartItem[]>([])

  const STORAGE_KEY = 'mini-ecommerce-cart'

  function saveToStorage() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(items.value))
  }

  function loadFromStorage() {
    const data = localStorage.getItem(STORAGE_KEY)
    if (data) {
      items.value = JSON.parse(data)
    }
  }

  // ✅ Executa só no client, após montagem
  onMounted(() => {
    loadFromStorage()
    watch(items, saveToStorage, { deep: true })
  })

  function addProduct(product: CartItem) {
    const existing = items.value.find(item => item.id === product.id)
    if (existing) {
      existing.quantity += product.quantity
    } else {
      items.value.push(product)
    }
  }

  function removeProduct(productId: number) {
    items.value = items.value.filter(item => item.id !== productId)
  }

  function updateQuantity(productId: number, quantity: number) {
    const item = items.value.find(i => i.id === productId)
    if (item) {
      item.quantity = quantity
    }
  }

  function clearCart() {
    items.value = []
  }

  return {
    items,
    addProduct,
    removeProduct,
    updateQuantity,
    clearCart,
  }
})
