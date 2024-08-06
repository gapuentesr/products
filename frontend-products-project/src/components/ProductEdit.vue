<template>
  <div class="p-4">
    <h2 class="text-xl font-bold mb-4">Edit Product</h2>
    <form @submit.prevent="submitForm">
      <div class="mb-4">
        <label for="code" class="block text-gray-700">Código</label>
        <input type="text" id="code" v-model="product.code" class="mt-1 block w-full border border-gray-300 rounded-md" required />
      </div>
      <div class="mb-4">
        <label for="name" class="block text-gray-700">Nombre</label>
        <input type="text" id="name" v-model="product.name" class="mt-1 block w-full border border-gray-300 rounded-md" required />
      </div>
      <div class="mb-4">
        <label for="price" class="block text-gray-700">Precio</label>
        <input type="number" id="price" v-model="product.price" class="mt-1 block w-full border border-gray-300 rounded-md" required />
      </div>
      <div class="mb-4">
        <label for="quantity" class="block text-gray-700">Cantidad</label>
        <input type="number" id="quantity" v-model="product.quantity" class="mt-1 block w-full border border-gray-300 rounded-md" required />
      </div>
      <div class="mb-4">
        <label for="description" class="block text-gray-700">Descripción</label>
        <textarea id="description" v-model="product.description" class="mt-1 block w-full border border-gray-300 rounded-md" rows="3"></textarea>
      </div>
      <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Guardar</button>
      <button @click="$emit('cancel')" type="button" class="px-4 py-2 bg-gray-500 text-white rounded ml-2">Cancelar</button>
    </form>

    <div v-if="error" class="text-red-500 mt-2">{{ error }}</div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    product: {
      type: Object,
      required: true
    },
    error: {
      type: String,
      default: null
    }
  },
  methods: {
    async submitForm() {
      try {
        await axios.put(`http://127.0.0.1:8000/api/products/${this.product.id}`, this.product);
        this.$emit('product-updated');
      } catch (error) {
        this.$emit('error', error.response?.data?.error || 'Error actualizando el producto');
      }
    }
  }
}
</script>
