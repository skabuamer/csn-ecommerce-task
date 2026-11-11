<script setup>
import { Link, router } from "@inertiajs/vue3";
import AppLayout from "../../Layouts/AppLayout.vue";

defineProps({ products: Array });

function remove(id) {
    if (confirm("Delete this product?")) router.delete(`/admin/products/${id}`);
}
</script>

<template>
    <AppLayout>
        <div
            class="mb-8 flex flex-col justify-between gap-5 sm:flex-row sm:items-center"
        >
            <h1
                class="font-serif text-4xl font-bold tracking-tight text-[#33251F] md:text-5xl"
            >
                Products
            </h1>
            <Link
                href="/admin/products/create"
                class="inline-flex items-center justify-center rounded-full bg-[#8F4038] px-6 py-3 text-sm font-semibold text-white shadow-md shadow-[#8F4038]/15 transition hover:bg-[#71332E]"
                >Add New product</Link
            >
        </div>

        <div
            class="overflow-x-auto rounded-3xl bg-[#FAF7F1] p-3 shadow-xl shadow-[#49352B]/5 md:p-5"
        >
            <table
                class="w-full min-w-[700px] border-separate border-spacing-0 text-left"
            >
                <thead
                    class="text-xs font-semibold uppercase tracking-wider text-[#89766A]"
                >
                    <tr>
                        <th class="border-b border-[#E5D9CD] px-5 py-4">
                            Image
                        </th>
                        <th class="border-b border-[#E5D9CD] px-5 py-4">
                            Title
                        </th>
                        <th class="border-b border-[#E5D9CD] px-5 py-4">
                            Price
                        </th>
                        <th class="border-b border-[#E5D9CD] px-5 py-4">
                            Created by
                        </th>
                        <th class="border-b border-[#E5D9CD] px-5 py-4">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="text-sm text-[#49382F]">
                    <tr
                        v-for="p in products"
                        :key="p.id"
                        class="transition hover:bg-[#F3ECE3]"
                    >
                        <td class="border-b border-[#EAE0D4] px-5 py-4">
                            <img
                                v-if="p.thumbnail_url"
                                :src="p.thumbnail_url"
                                class="h-14 w-14 rounded-xl object-cover shadow-sm"
                            />
                            <div
                                v-else
                                class="flex h-14 w-14 items-center justify-center rounded-xl bg-[#EAE0D4] text-xs text-[#89766A]"
                            >
                                No image
                            </div>
                        </td>
                        <td
                            class="border-b border-[#EAE0D4] px-5 py-4 font-semibold text-[#33251F]"
                        >
                            {{ p.title }}
                        </td>
                        <td
                            class="border-b border-[#EAE0D4] px-5 py-4 font-medium text-[#8F4038]"
                        >
                            {{ p.price }}
                        </td>
                        <td class="border-b border-[#EAE0D4] px-5 py-4">
                            {{ p.creator?.name }}
                        </td>
                        <td class="border-b border-[#EAE0D4] px-5 py-4">
                            <div class="flex items-center gap-4">
                                <Link
                                    :href="`/admin/products/${p.id}/edit`"
                                    class="font-semibold text-[#8F4038] transition hover:text-[#71332E]"
                                    >Edit</Link
                                >
                                <button
                                    @click="remove(p.id)"
                                    class="font-semibold text-[#A33D36] transition hover:text-[#7F2C28]"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
