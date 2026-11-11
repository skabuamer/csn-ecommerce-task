<script setup>
import { Link } from "@inertiajs/vue3";
import AppLayout from "../Layouts/AppLayout.vue";

defineProps({ shops: Array, listings: Array });
</script>

<template>
    <AppLayout>
        <h1
            class="mb-8 text-4xl font-semibold tracking-tight text-[#33251F] md:text-5xl"
        >
            Browse
            <span class="font-serif italic font-normal text-[#9A493B]"
                >shops.</span
            >
        </h1>

        <div class="mb-16 grid grid-cols-1 gap-6 md:grid-cols-3">
            <Link
                v-for="s in shops"
                :key="s.id"
                :href="`/shops/${s.slug}`"
                class="group relative overflow-hidden rounded-2xl bg-[#EAE0D4] p-8 transition-all duration-300 hover:-translate-y-1 hover:bg-[#E4D4C3] hover:shadow-xl hover:shadow-[#49352B]/10"
            >
                <div
                    class="text-2xl font-semibold tracking-tight text-[#33251F]"
                >
                    {{ s.name }}
                </div>
                <div class="mt-3 text-sm font-medium text-[#89766A]">
                    {{ s.products_count }} products
                </div>
            </Link>
        </div>

        <h1
            class="mb-8 text-4xl font-semibold tracking-tight text-[#33251F] md:text-5xl"
        >
            Browse
            <span class="font-serif italic font-normal text-[#9A493B]"
                >Products.</span
            >
        </h1>

        <div
            class="grid grid-cols-1 gap-7 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
            <div
                v-for="l in listings"
                :key="l.id"
                class="group overflow-hidden rounded-2xl bg-[#FAF7F1] shadow-sm shadow-[#49352B]/5 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#49352B]/10"
            >
                <img
                    v-if="l.display_thumbnail"
                    :src="l.display_thumbnail"
                    class="h-52 w-full rounded-t-2xl object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                />
                <div
                    v-else
                    class="flex h-52 w-full items-center justify-center rounded-t-2xl bg-[#EAE0D4] text-sm font-medium text-[#9A493B]"
                >
                    No image
                </div>
                <div class="p-5">
                    <div
                        class="text-lg font-semibold tracking-tight text-[#33251F]"
                    >
                        {{ l.display_title }}
                    </div>
                    <div class="mt-2 text-sm leading-6 text-[#89766A]">
                        {{ l.display_details }}
                    </div>
                    <div class="mt-4 text-xl font-semibold text-[#9A493B]">
                        ৳ {{ l.price }}
                    </div>

                    <Link
                        :href="`/shops/${l.shop.slug}`"
                        class="mt-4 inline-block text-xs font-semibold underline uppercase tracking-wider text-[#89766A] transition-colors hover:text-[#9A493B]"
                        >{{ l.shop.name }}</Link
                    >
                </div>
            </div>
        </div>
    </AppLayout>
</template>
