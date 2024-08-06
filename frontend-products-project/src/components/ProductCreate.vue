<template>
  <div class="p-4">
    <h2 class="text-xl font-bold mb-4">Add New Product</h2>
    <form @submit.prevent="submitForm">
      <div class="mb-4">
        <label for="code" class="block text-gray-700">Code</label>
        <input type="text" id="code" v-model="product.code" class="mt-1 block w-full border border-gray-300 rounded-md" required />
      </div>
      <div class="mb-4">
        <label for="name" class="block text-gray-700">Name</label>
        <input type="text" id="name" v-model="product.name" class="mt-1 block w-full border border-gray-300 rounded-md" required />
      </div>
      <div class="mb-4">
        <label for="price" class="block text-gray-700">Price</label>
        <input type="number" id="price" v-model="product.price" class="mt-1 block w-full border border-gray-300 rounded-md" required />
      </div>
      <div class="mb-4">
        <label for="quantity" class="block text-gray-700">Quantity</label>
        <input type="number" id="quantity" v-model="product.quantity" class="mt-1 block w-full border border-gray-300 rounded-md" required />
      </div>
      <div class="mb-4">
        <label for="description" class="block text-gray-700">Description</label>
        <textarea id="description" v-model="product.description" class="mt-1 block w-full border border-gray-300 rounded-md" rows="3"></textarea>
      </div>
      <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Submit</button>
      <button @click="$emit('cancel')" type="button" class="px-4 py-2 bg-gray-500 text-white rounded ml-2">Cancel</button>
    </form>

    <div v-if="error" class="mt-4 text-red-500">{{ error }}</div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    error: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      product: {
        code: '',
        name: '',
        price: 0,
        quantity: 1,
        description: ''
      }
    };
  },
  methods: {
    async submitForm() {
      try {
        await axios.post('http://127.0.0.1:8000/api/products', this.product);
        this.$emit('product-added');
      } catch (error) {
        this.$emit('error', error.response?.data?.error || 'Error creating product');
      }
    }
  }
}
</script>
