<template>
  <div class="container mx-auto p-4">
    <div v-if="message" :class="message.type === 'error' ? 'bg-red-500' : 'bg-green-500'" class="text-white p-4 mb-4 rounded">
      {{ message.text }}
    </div>

    <button v-if="!isCreating && !isEditing" @click="showCreateForm" class="px-4 py-2 bg-green-500 text-white rounded mb-4">
      Agregar producto
    </button>

    <ProductList
      v-if="!isCreating && !isEditing"
      :products="products"
      @edit="startEdit"
      @delete="deleteProduct"
    />

    <ProductCreate
      v-if="isCreating"
      @product-added="handleProductAdded"
      @cancel="cancelCreate"
      @error="handleError"
    />

    <ProductEdit
      v-if="isEditing"
      :product="currentProduct"
      @product-updated="handleProductUpdated"
      @cancel="cancelEdit"
      @error="handleError"
    />
  </div>
</template>

<script>
import axios from 'axios';
import ProductList from './components/ProductList.vue';
import ProductCreate from './components/ProductCreate.vue';
import ProductEdit from './components/ProductEdit.vue';

export default {
  components: {
    ProductList,
    ProductCreate,
    ProductEdit
  },
  data() {
    return {
      products: [],
      currentProduct: null,
      isEditing: false,
      isCreating: false,
      message: null
    };
  },
  methods: {
    async fetchProducts() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/products');
        this.products = response.data;
      } catch (error) {
        this.message = {
          text: error.response?.data?.error || 'Error actualizando lista.',
          type: 'error'
        };
      }
    },
    async deleteProduct(id) {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/products/${id}`);
        this.fetchProducts();
        this.message = { text: 'Product eliminado', type: 'success' };
        this.clearMessage();
      } catch (error) {
        this.message = {
          text: error.response?.data?.error || 'Error eliminando el producto.',
          type: 'error'
        };
        this.clearMessage();
      }
    },
    startEdit(product) {
      this.currentProduct = { ...product };
      this.isEditing = true;
      this.isCreating = false;
    },
    showCreateForm() {
      this.currentProduct = { code: '', name: '', price: 0, quantity: 1, description: '' };
      this.isEditing = false;
      this.isCreating = true;
    },
    handleProductAdded() {
      this.isCreating = false;
      this.fetchProducts();
      this.message = { text: 'Producto agregado', type: 'success' };
      this.clearMessage();
    },
    handleProductUpdated() {
      this.isEditing = false;
      this.fetchProducts();
      this.message = { text: 'Product acualizado', type: 'warning' };
      this.clearMessage();
    },
    cancelCreate() {
      this.isCreating = false;
    },
    cancelEdit() {
      this.isEditing = false;
    },
    handleError(error) {
      this.message = {
        text: error,
        type: 'error'
      };
      this.clearMessage();
    },
    clearMessage() {
      setTimeout(() => {
        this.message = null;
      }, 4000);
    }
  },
  mounted() {
    this.fetchProducts();
  }
}
</script>
