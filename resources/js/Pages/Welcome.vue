<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import { Head, Link, router } from '@inertiajs/vue3'

defineProps<{
  canLogin?: boolean
  canRegister?: boolean
  laravelVersion: string
  phpVersion: string
}>()
</script>

<template>
  <Head title="Welcome" />
  <div
    class="flex h-[100vh] flex-col justify-between bg-gray-50 text-black/70 dark:bg-black dark:text-white/50"
  >
    <header class="grid grid-cols-2 items-center gap-2 py-8 lg:grid-cols-3">
      <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
        <template v-if="!$page.props.auth.user">
          <Link
            :href="route('login')"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
          >
            Log in
          </Link>

          <Link
            v-if="canRegister"
            :href="route('register')"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
          >
            Register
          </Link>
        </template>
      </nav>
    </header>

    <main class="mt-6 flex flex-1 flex-col">
      <div class="flex flex-col items-center justify-center gap-4 sm:flex-row sm:gap-12">
        <ApplicationLogo class="w-24" />
        <h1 class="text-4xl font-bold sm:text-[5rem]">BGHMC CP1 Exam</h1>
      </div>
      <div
        class="flex flex-1 flex-col items-center justify-center gap-4 p-12 sm:flex-row sm:gap-12 [&>*]:h-52 [&>*]:w-96 [&>*]:flex-1"
      >
        <SecondaryButton @click="router.visit(route('patients'))">
          <span class="text-2xl sm:text-[3rem]">Patients</span>
        </SecondaryButton>
        <SecondaryButton @click="router.visit(route('admissions'))">
          <span class="text-2xl sm:text-[3rem]">Admissions</span>
        </SecondaryButton>
      </div>
    </main>

    <footer class="py-8 text-center text-sm text-black dark:text-white/70">
      Sian Caleb Domasig 2024
    </footer>
  </div>
</template>
