<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Lista de productos</h1>
    <table class="min-w-full bg-white border border-gray-200">
      <thead>
        <tr>
          <th class="border px-4 py-2">Código</th>
          <th class="border px-4 py-2">Nombre</th>
          <th class="border px-4 py-2">Precio</th>
          <th class="border px-4 py-2">Cantidad</th>
          <th class="border px-4 py-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td class="border px-4 py-2">{{ product.code }}</td>
          <td class="border px-4 py-2">{{ product.name }}</td>
          <td class="border px-4 py-2">
            {{ (parseFloat(product.price) || 0).toFixed(2) }}
          </td>
          <td class="border px-4 py-2">{{ product.quantity }}</td>
          <td class="border px-4 py-2">
            <button @click="editProduct(product)" class="bg-blue-500 text-white px-2 py-1 rounded">Editar</button>
            <button @click="deleteProduct(product.id)" class="bg-red-500 text-white px-2 py-1 rounded ml-2">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: ['products', 'onEdit', 'onDelete'],
  methods: {
    editProduct(product) {
      this.$emit('edit', product);
    },
    deleteProduct(id) {
      this.$emit('delete', id);
    }
  }
}
</script>

<style scoped>
/* Add any custom styles here */
</style>
