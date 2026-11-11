<script setup>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "../../Layouts/AppLayout.vue";

const props = defineProps({ product: Object });

const form = useForm({
    title: props.product?.title ?? "",
    details: props.product?.details ?? "",
    price: props.product?.price ?? "",
    thumbnail: null,
});

function submit() {
    if (props.product) {
        // Files can't be sent with a real PUT, so we POST and add _method: 'put'.
        form.transform((d) => ({ ...d, _method: "put" })).post(
            `/admin/products/${props.product.id}`,
            { forceFormData: true },
        );
    } else {
        form.post("/admin/products", { forceFormData: true });
    }
}
</script>

<template>
    <AppLayout>
        <h1
            class="mb-8 font-serif text-4xl font-bold tracking-tight text-[#33251F] md:text-5xl"
        >
            {{ product ? "Edit" : "New" }}
            <span class="font-normal italic text-[#9A493B]">product</span>
        </h1>
        <form
            @submit.prevent="submit"
            class="max-w-xl space-y-6 rounded-3xl bg-[#FAF7F1] p-7 shadow-xl shadow-[#49352B]/5 md:p-9"
        >
            <div>
                <input
                    v-model="form.title"
                    placeholder="Title"
                    class="w-full rounded-xl border border-[#D8C8B9] bg-[#F7F3ED] px-4 py-3.5 text-sm text-[#33251F] outline-none transition placeholder:text-[#A69588] focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
                />
                <div
                    v-if="form.errors.title"
                    class="mt-2 text-sm text-[#A33D36]"
                >
                    {{ form.errors.title }}
                </div>
            </div>
            <textarea
                v-model="form.details"
                placeholder="Details"
                class="w-full resize-y rounded-xl border border-[#D8C8B9] bg-[#F7F3ED] px-4 py-3.5 text-sm text-[#33251F] outline-none transition placeholder:text-[#A69588] focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
                rows="4"
            />
            <div>
                <input
                    v-model="form.price"
                    type="number"
                    step="0.01"
                    placeholder="Price"
                    class="w-full rounded-xl border border-[#D8C8B9] bg-[#F7F3ED] px-4 py-3.5 text-sm text-[#33251F] outline-none transition placeholder:text-[#A69588] focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
                />
                <div
                    v-if="form.errors.price"
                    class="mt-2 text-sm text-[#A33D36]"
                >
                    {{ form.errors.price }}
                </div>
            </div>
            <div>
                <img
                    v-if="product?.thumbnail_url"
                    :src="product.thumbnail_url"
                    class="mb-3 h-24 w-24 rounded-2xl object-cover shadow-sm"
                />
                <input
                    type="file"
                    accept="image/*"
                    @change="form.thumbnail = $event.target.files[0]"
                    class="w-full rounded-xl border border-dashed border-[#CDBBAA] bg-[#F7F3ED] p-4 text-sm text-[#76665C] file:mr-4 file:rounded-full file:border-0 file:bg-[#EAE0D4] file:px-4 file:py-2 file:text-xs file:font-semibold file:text-[#49382F] hover:file:bg-[#DED0C1]"
                />
                <div
                    v-if="form.errors.thumbnail"
                    class="mt-2 text-sm text-[#A33D36]"
                >
                    {{ form.errors.thumbnail }}
                </div>
            </div>
            <button
                :disabled="form.processing"
                class="rounded-full bg-[#8F4038] px-8 py-3 text-sm font-semibold text-white shadow-md shadow-[#8F4038]/15 transition hover:bg-[#71332E] disabled:opacity-50"
            >
                Save
            </button>
        </form>
    </AppLayout>
</template>
