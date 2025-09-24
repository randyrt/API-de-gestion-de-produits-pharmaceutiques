<template>
  <Loading v-if="loading" message="Récupération des utilisateurs..." />
  <div v-else class="p-4 mt-4 border border-gray-300 rounded bg-sky-50">
    <h2 class="text-lg font-semibold text-blue-600">Liste des utilisateurs</h2>
    <ul>
      <li class="text-gray-400" v-for="user in users" :key="user.id">
       - {{ user.name }} ({{ user.email }})
      </li>
    </ul>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import Loading from './components/Loading.vue';
import { getData } from './services/api';

interface User {
  id: number;
  name: string;
  email: string;
}

export default defineComponent({
  components: { Loading },
  setup() {
    const users = ref<User[]>([]);
    const loading = ref(true);

    onMounted(async () => {
      try {
        users.value = await getData<User[]>('/user');
      } finally {
        loading.value = false;
      }
    });

    return { users, loading };
  }
});
</script>
