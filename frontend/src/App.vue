<!-- <template>
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
</script> -->
<template>
  <Loading v-if="loading" message="Paiement en cours..." />
  <div v-else class="p-4 mt-4 text-black">
    <h2 class="text-lg font-semibold">Réponse Mvola :</h2>
    <pre class="bg-gray-100 p-2 rounded w-full">{{ response ?? "Aucun résultat" }}</pre>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { makeMerchantPay } from './services/Mvola'
import Loading from './components/Loading.vue'


const loading = ref(true)
const response = ref<any>(null)

onMounted(async () => {
  try {
    const payload = {
      amount: "100000000",
      currency: "Ar",
      descriptionText: "Paiement test via MVola API",
      requestDate: new Date().toISOString(),
      debitParty: [{ key: "msisdn", value: "0343500004" }],
      creditParty: [{ key: "msisdn", value: "0341471339"}],
      metadata: [{ key: "partnerName", value: "MVola_App_Test" }]
    }

    response.value = await makeMerchantPay(payload)
    console.log('Réponse Mvola:', response.value)
  } catch (error: any) {
    console.error('Erreur API Mvola:', error.response?.data || error.message)
  } finally {
    loading.value = false
  }
})
</script>



