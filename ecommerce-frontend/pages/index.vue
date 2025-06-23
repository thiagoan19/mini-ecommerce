<script setup>
import { ref, computed, watch } from 'vue'

const page = ref(1)
const categoryFilter = ref('Todos')
const searchTerm = ref('')

const { data, pending, error, refresh } = await useFetch(() => {
  // Monta URL com query params dinâmicos
  let url = `http://127.0.0.1:8000/api/products?page=${page.value}`
  
  if (categoryFilter.value !== 'Todos') {
    url += `&category=${encodeURIComponent(categoryFilter.value)}`
  }
  if (searchTerm.value.trim()) {
    url += `&search=${encodeURIComponent(searchTerm.value.trim())}`
  }
  
  return url
}, {
  default: () => ({
    data: [],
    current_page: 1,
    last_page: 1,
  }),
})

const productsList = computed(() => data.value?.data ?? [])
const currentPage = computed(() => data.value?.current_page ?? 1)
const lastPage = computed(() => data.value?.last_page ?? 1)

const categories = ref(['Todos']) // Vamos buscar categorias fixas ou dinamicamente

// Filtra categoria e reseta página
function filterByCategory(cat) {
  categoryFilter.value = cat
  page.value = 1
}

// Busca por nome e reseta página
function onSearch() {
  page.value = 1
}

// Navegação da paginação
function goToPage(p) {
  if (p >= 1 && p <= lastPage.value) {
    page.value = p
  }
}

// Opcional: buscar categorias no mount (ou hardcode)
categories.value.push('men\'s clothing', 'jewelery', 'electronics', 'women\'s clothing')

// Quando página, categoria ou busca mudam, refaz a consulta
watch([page, categoryFilter, searchTerm], () => {
  refresh()
})
</script>

<template>
  <div>
    <h1>Produtos</h1>

    <div class="filters" style="margin-bottom: 20px">
      <input
        v-model="searchTerm"
        @input="onSearch"
        type="text"
        placeholder="Buscar produtos..."
        style="margin-right: 1rem"
      />

      <button
        v-for="cat in categories"
        :key="cat"
        @click="filterByCategory(cat)"
        :class="['category-button', { active: cat === categoryFilter }]"
      >
        {{ cat }}
      </button>
    </div>

    <div v-if="pending">Carregando produtos...</div>
    <div v-else-if="error" class="error">Erro ao carregar produtos.</div>
    <div v-else>
      <div class="product-grid">
        <div
          v-for="product in productsList"
          :key="product.id"
          class="product-card"
        >
          <NuxtLink :to="`/products/${product.id}`">
            <img
              :src="product.image_url"
              :alt="product.title"
              class="product-image"
            />
          </NuxtLink>
          <h2 class="product-name">{{ product.title }}</h2>
          <p class="product-category">{{ product.category }}</p>
          <p class="product-price">R$ {{ Number(product.price).toFixed(2) }}</p>
        </div>
      </div>

      <!-- Paginação simples -->
      <div class="pagination" style="margin-top: 20px;">
        <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1">
          Anterior
        </button>

        <span>Página {{ currentPage }} de {{ lastPage }}</span>

        <button @click="goToPage(currentPage + 1)" :disabled="currentPage === lastPage">
          Próxima
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.category-button {
  margin-right: 0.5rem;
  padding: 0.3rem 0.7rem;
  cursor: pointer;
}
.category-button.active {
  font-weight: bold;
  background-color: #3490dc;
  color: white;
}
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 1rem;
}
.product-card {
  border: 1px solid #ddd;
  padding: 1rem;
  border-radius: 8px;
}
.product-image {
  width: 100%;
  height: 140px;
  object-fit: contain;
}
.pagination button {
  padding: 0.4rem 0.8rem;
  margin: 0 0.5rem;
  cursor: pointer;
}
.pagination button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
.error {
  color: red;
}
</style>
