<script setup>
import { Link } from "@inertiajs/vue3";
import AppLayout from "../Layouts/AppLayout.vue";

defineProps({ shop: Object, listings: Array });
</script>

<template>
    <AppLayout>
        <Link
            href="/"
            class="inline-flex items-center text-sm font-medium text-[#8F4038] transition-colors hover:text-[#C18A52]"
        >
            ← All shops
        </Link>

        <h1
            class="my-6 font-serif text-4xl font-bold tracking-tight text-[#33251F] md:text-5xl"
        >
            {{ shop.name }}
        </h1>

        <p
            v-if="!listings.length"
            class="rounded-2xl bg-[#EAE0D4] px-6 py-8 text-[#89766A]"
        >
            This shop has no products yet.
        </p>

        <div
            class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
            <div
                v-for="l in listings"
                :key="l.id"
                class="group overflow-hidden rounded-2xl bg-[#FAF7F1] shadow-sm shadow-[#49352B]/5 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#49352B]/10"
            >
                <img
                    v-if="l.display_thumbnail"
                    :src="l.display_thumbnail"
                    class="h-52 w-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                />
                <div
                    v-else
                    class="flex h-52 w-full items-center justify-center bg-[#EAE0D4] text-sm font-medium text-[#9A493B]"
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
                </div>
            </div>
        </div>
    </AppLayout>
</template>
