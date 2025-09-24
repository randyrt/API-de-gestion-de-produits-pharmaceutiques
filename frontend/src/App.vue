<template>
  <Loading v-if="loading" message="Récupération des utilisateurs..." />
  <div v-else class="p-4 mt-4">
    <h2 class="text-lg font-semibold text-black">Liste des utilisateurs</h2>
    <ul>
      <li class="text-black" v-for="user in users" :key="user.id">
       - {{ user.name }} ({{ user.email }})
      </li>
    </ul>
  </div>
  <motion />
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import Loading from './components/Loading.vue';
import Motion from './components/Motion.vue';
import { getData } from './services/api';

interface User {
  id: number;
  name: string;
  email: string;
}

export default defineComponent({
  components: { Loading, Motion },
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
