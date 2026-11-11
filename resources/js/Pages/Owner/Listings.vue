<script setup>
import { router } from "@inertiajs/vue3";
import { reactive } from "vue";
import AppLayout from "../../Layouts/AppLayout.vue";

const props = defineProps({ listings: Array });
const editing = reactive({});

// local editable copy of each listing
const edits = reactive(
    Object.fromEntries(
        props.listings.map((l) => [
            l.id,
            {
                title: l.title ?? "",
                details: l.details ?? "",
                price: l.price,
                thumbnail: null,
            },
        ]),
    ),
);

function save(l) {
    router.post(`/owner/listings/${l.id}`, edits[l.id], {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => (editing[l.id] = false),
    });
}
function remove(l) {
    if (confirm("Remove this product from your shop?"))
        router.delete(`/owner/listings/${l.id}`, { preserveScroll: true });
}
</script>

<template>
    <AppLayout>
        <h1
            class="mb-8 font-serif text-4xl font-bold tracking-tight text-[#33251F] md:text-5xl"
        >
            My shop's
            <span class="font-normal italic text-[#9A493B]">products</span>
        </h1>

        <p
            v-if="!listings.length"
            class="rounded-2xl bg-[#EAE0D4] px-6 py-8 text-sm text-[#89766A]"
        >
            Nothing listed yet. Go to the Catalog to add products.
        </p>

        <div class="grid gap-5">
            <div
                v-for="l in listings"
                :key="l.id"
                class="grid gap-5 overflow-hidden rounded-2xl bg-[#FAF7F1] p-5 shadow-sm shadow-[#49352B]/5 transition-shadow hover:shadow-lg hover:shadow-[#49352B]/10 md:grid-cols-[128px_1fr] md:p-6"
            >
                <img
                    v-if="l.display_thumbnail"
                    :src="l.display_thumbnail"
                    class="h-32 w-full rounded-xl object-cover md:w-32"
                />

                <div
                    v-else
                    class="flex h-40 w-full items-center justify-center rounded-xl bg-[#EAE0D4] text-sm text-[#9A493B] md:h-32 md:w-32"
                >
                    No image
                </div>

                <div v-if="!editing[l.id]" class="flex flex-col justify-center">
                    <div
                        class="text-xl font-semibold tracking-tight text-[#33251F]"
                    >
                        {{ l.display_title }}
                    </div>
                    <div class="mt-2 text-sm leading-6 text-[#89766A]">
                        {{ l.display_details }}
                    </div>
                    <div class="mt-3 text-xl font-semibold text-[#9A493B]">
                        ৳ {{ l.price }}
                    </div>

                    <div class="mt-4 flex items-center gap-4">
                        <button
                            @click="editing[l.id] = true"
                            class="text-sm font-semibold text-[#8F4038] transition-colors hover:text-[#C18A52]"
                        >
                            Edit
                        </button>
                        <button
                            @click="remove(l)"
                            class="text-sm font-semibold text-[#A33D36] transition-colors hover:text-[#762B27]"
                        >
                            Remove
                        </button>
                    </div>
                </div>

                <div v-else class="grid gap-4">
                    <div class="grid gap-3">
                        <input
                            v-model="edits[l.id].title"
                            :placeholder="l.product.title"
                            class="w-full rounded-xl border border-[#D8C8B9] bg-[#F7F3ED] px-4 py-3 text-sm text-[#33251F] outline-none transition focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
                        />
                        <textarea
                            v-model="edits[l.id].details"
                            :placeholder="l.product.details || 'Details'"
                            class="min-h-28 w-full rounded-xl border border-[#D8C8B9] bg-[#F7F3ED] px-4 py-3 text-sm text-[#33251F] outline-none transition focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
                        />
                        <input
                            v-model="edits[l.id].price"
                            type="number"
                            step="0.01"
                            class="w-40 rounded-xl border border-[#D8C8B9] bg-[#F7F3ED] px-4 py-3 text-sm text-[#33251F] outline-none focus:border-[#9A493B]"
                        />
                        <input
                            type="file"
                            accept="image/*"
                            @change="
                                edits[l.id].thumbnail = $event.target.files[0]
                            "
                            class="w-full text-sm text-[#76665C] file:mr-4 file:rounded-full file:border-0 file:bg-[#EAE0D4] file:px-4 file:py-2 file:text-xs file:font-semibold file:text-[#8F4038]"
                        />
                        <div class="flex items-center gap-4 pt-1">
                            <button
                                @click="save(l)"
                                class="rounded-full bg-[#8F4038] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#71332E]"
                            >
                                Save
                            </button>
                            <button
                                @click="remove(l)"
                                class="text-sm font-semibold text-[#A33D36] transition-colors hover:text-[#762B27]"
                            >
                                Remove from shop
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
