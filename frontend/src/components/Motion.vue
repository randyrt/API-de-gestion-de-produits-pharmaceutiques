<template>
  <div class="flex flex-col items-center justify-center min-h-screen gap-6">
 
    <m-motion
      :initial="{ opacity: 0, y: -50 }"
      :enter="{ opacity: 1, y: 0, transition: { duration: 0.8 } }"
      class="p-6 text-white bg-blue-500 rounded-lg shadow-lg"
    >
      Bonjour, je suis animé !
    </m-motion>

  
    <m-motion
      :while-hover="{ scale: 1.1, rotate: 5 }"
      class="p-6 text-white bg-green-500 rounded-lg shadow-lg cursor-pointer"
    >
      Passe la souris ici !
    </m-motion>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { Motion } from "motion-v";

export default defineComponent({
  name: "AnimationExample",
  components: {
    "m-motion": Motion
  }
});
</script>

