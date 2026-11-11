<script setup>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "../../Layouts/AppLayout.vue";

const form = useForm({ email: "", password: "" });
</script>

<template>
    <AppLayout>
        <form
            @submit.prevent="form.post('/login')"
            class="mx-auto mt-16 max-w-md space-y-6 rounded-3xl bg-[#FAF7F1] p-8 shadow-xl shadow-[#49352B]/10 md:p-10"
        >
            <h1
                class="font-serif text-4xl font-bold tracking-tight text-[#33251F]"
            >
                Login<span class="text-[#9A493B]">.</span>
            </h1>

            <input
                v-model="form.email"
                type="email"
                placeholder="Email"
                class="w-full rounded-xl border border-[#D8C8B9] bg-[#F7F3ED] px-4 py-3.5 text-sm text-[#33251F] outline-none transition placeholder:text-[#A69588] focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
            />

            <div v-if="form.errors.email" class="text-sm text-[#A33D36]">
                {{ form.errors.email }}
            </div>

            <input
                v-model="form.password"
                type="password"
                placeholder="Password"
                class="w-full rounded-xl border border-[#D8C8B9] bg-[#F7F3ED] px-4 py-3.5 text-sm text-[#33251F] outline-none transition placeholder:text-[#A69588] focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
            />

            <button
                :disabled="form.processing"
                class="w-full rounded-full bg-[#8F4038] px-6 py-3.5 text-sm font-semibold text-white shadow-md shadow-[#8F4038]/15 transition hover:bg-[#71332E] disabled:opacity-50"
            >
                Login
            </button>
        </form>
    </AppLayout>
</template>
