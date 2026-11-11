<script setup>
import { router, useForm } from "@inertiajs/vue3";
import { reactive } from "vue";
import AppLayout from "../../Layouts/AppLayout.vue";

const props = defineProps({ products: Array, listedIds: Array });

const adding = reactive({}); // which product's form is open
const drafts = reactive(
    Object.fromEntries(
        props.products.map((p) => [
            p.id,
            {
                title: "",
                details: "",
                price: p.price ?? 0,
                thumbnail: null,
            },
        ]),
    ),
);

function add(p) {
    router.post(`/owner/catalog/${p.id}/add`, drafts[p.id], {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => (adding[p.id] = false),
    });
}

const form = useForm({ title: "", details: "", price: "", thumbnail: null });
function createProduct() {
    form.post("/owner/products", {
        forceFormData: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <AppLayout>
        <h1
            class="mb-8 font-serif text-4xl font-bold tracking-tight text-[#33251F] md:text-5xl"
        >
            Shared
            <span class="font-normal italic text-[#9A493B]">catalog</span>
        </h1>

        <form
            @submit.prevent="createProduct"
            class="mb-12 grid max-w-full gap-5 rounded-2xl bg-[#EAE0D4] p-6 shadow-sm shadow-[#49352B]/5 md:p-8"
        >
            <h2 class="font-serif text-2xl font-bold text-[#33251F]">
                Create a new product
            </h2>

            <input
                v-model="form.title"
                placeholder="Title"
                class="w-full rounded-xl border border-[#D8C8B9] bg-[#FAF7F1] px-4 py-3 text-sm text-[#33251F] outline-none transition focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
            />

            <div v-if="form.errors.title" class="text-sm text-[#A33D36]">
                {{ form.errors.title }}
            </div>

            <textarea
                v-model="form.details"
                placeholder="Details"
                class="min-h-28 w-full resize-y rounded-xl border border-[#D8C8B9] bg-[#FAF7F1] px-4 py-3 text-sm text-[#33251F] outline-none transition focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
            />
            <div v-if="form.errors.details" class="text-sm text-[#A33D36]">
                {{ form.errors.details }}
            </div>

            <input
                v-model="form.price"
                type="number"
                step="0.01"
                placeholder="Price"
                class="w-full rounded-xl border border-[#D8C8B9] bg-[#FAF7F1] px-4 py-3 text-sm text-[#33251F] outline-none transition focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
            />

            <div v-if="form.errors.price" class="text-sm text-[#A33D36]">
                {{ form.errors.price }}
            </div>

            <input
                type="file"
                accept="image/*"
                @change="form.thumbnail = $event.target.files[0]"
                class="w-full rounded-xl border border-[#D8C8B9] bg-[#FAF7F1] p-3 text-sm text-[#76665C] file:mr-4 file:rounded-full file:border-0 file:bg-[#EAE0D4] file:px-4 file:py-2 file:text-xs file:font-semibold file:text-[#8F4038]"
            />
            <div v-if="form.errors.thumbnail" class="text-sm text-[#A33D36]">
                {{ form.errors.thumbnail }}
            </div>

            <button
                :disabled="form.processing"
                class="w-fit rounded-full bg-[#8F4038] px-7 py-3 text-sm font-semibold text-white shadow-md shadow-[#8F4038]/15 transition hover:bg-[#71332E] disabled:opacity-50"
            >
                Create and list in my shop
            </button>
        </form>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div
                v-for="p in products"
                :key="p.id"
                class="space-y-3 overflow-hidden rounded-2xl bg-[#FAF7F1] shadow-sm shadow-[#49352B]/5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#49352B]/10"
            >
                <img
                    v-if="p.thumbnail_url"
                    :src="p.thumbnail_url"
                    class="h-52 w-full object-cover"
                />
                <div
                    v-else
                    class="flex h-52 w-full items-center justify-center bg-[#EAE0D4] text-sm text-[#9A493B]"
                >
                    No image
                </div>

                <div class="space-y-3 p-5 pt-2">
                    <div class="font-semibold tracking-tight text-[#33251F]">
                        {{ p.title }}
                    </div>
                    <div class="text-sm leading-6 text-[#89766A]">
                        {{ p.details }}
                    </div>

                    <div
                        v-if="listedIds.includes(p.id)"
                        class="rounded-xl bg-[#E5EDDF] px-4 py-3 text-sm font-medium text-[#466247]"
                    >
                        ✓ Listed in your shop
                    </div>

                    <div v-else>
                        <button
                            v-if="!adding[p.id]"
                            @click="adding[p.id] = true"
                            class="rounded-full bg-[#8F4038] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#71332E]"
                        >
                            Add to my shop
                        </button>

                        <div
                            v-else
                            class="grid gap-3 rounded-xl bg-[#EAE0D4] p-4"
                        >
                            <input
                                v-model="drafts[p.id].title"
                                :placeholder="p.title"
                                class="w-full rounded-lg border border-[#D8C8B9] bg-[#FAF7F1] px-3 py-2.5 text-sm text-[#33251F] outline-none focus:border-[#9A493B]"
                            />

                            <textarea
                                v-model="drafts[p.id].details"
                                :placeholder="p.details || 'Details'"
                                class="w-full rounded-lg border border-[#D8C8B9] bg-[#FAF7F1] px-3 py-2.5 text-sm text-[#33251F] outline-none focus:border-[#9A493B]"
                            />

                            <input
                                v-model="drafts[p.id].price"
                                type="number"
                                step="0.01"
                                class="w-full rounded-lg border border-[#D8C8B9] bg-[#FAF7F1] px-3 py-2.5 text-sm text-[#33251F] outline-none focus:border-[#9A493B]"
                            />

                            <input
                                type="file"
                                accept="image/*"
                                @change="
                                    drafts[p.id].thumbnail =
                                        $event.target.files[0]
                                "
                                class="w-full text-xs text-[#76665C] file:mr-3 file:rounded-full file:border-0 file:bg-[#FAF7F1] file:px-3 file:py-2 file:font-medium file:text-[#8F4038]"
                            />

                            <div class="flex items-center gap-3 pt-1">
                                <button
                                    @click="add(p)"
                                    class="rounded-full bg-[#8F4038] px-5 py-2 text-sm font-semibold text-white transition hover:bg-[#71332E]"
                                >
                                    Save
                                </button>

                                <button
                                    @click="adding[p.id] = false"
                                    class="text-sm font-medium text-[#89766A] transition hover:text-[#9A493B]"
                                >
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
