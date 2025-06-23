<template>
  <div>
    <h1>Teste API</h1>
    <div v-if="pending">Carregando...</div>
    <div v-else-if="error">Erro: {{ error.message }}</div>
    <pre v-else>{{ data }}</pre>
  </div>
</template>

<script setup lang="ts">
const { data, pending, error } = await useFetch('http://127.0.0.1:8000/api/products')
</script>
