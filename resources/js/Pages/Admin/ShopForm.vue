<script setup>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "../../Layouts/AppLayout.vue";

const props = defineProps({ shop: Object, owners: Array });

const form = useForm({
    name: props.shop?.name ?? "",
    owner_id: props.shop?.owner_id ?? "",
});

function submit() {
    if (props.shop) {
        form.put(`/admin/shops/${props.shop.id}`);
    } else {
        form.post("/admin/shops");
    }
}
</script>

<template>
    <AppLayout>
        <h1
            class="mb-8 font-serif text-4xl font-bold tracking-tight text-[#33251F] md:text-5xl"
        >
            {{ shop ? "Edit" : "New" }}
            <span class="font-normal italic text-[#9A493B]">Shop</span>
        </h1>
        <form
            @submit.prevent="submit"
            class="max-w-xl space-y-6 rounded-3xl bg-[#FAF7F1] p-7 shadow-xl shadow-[#49352B]/5 md:p-9"
        >
            <div>
                <input
                    v-model="form.name"
                    placeholder="Name"
                    class="w-full rounded-xl border border-[#D8C8B9] bg-[#F7F3ED] px-4 py-3.5 text-sm text-[#33251F] outline-none transition placeholder:text-[#A69588] focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
                />
                <div
                    v-if="form.errors.name"
                    class="mt-2 text-sm text-[#A33D36]"
                >
                    {{ form.errors.name }}
                </div>
            </div>
            <div>
                <select
                    v-model="form.owner_id"
                    class="w-full rounded-xl border border-[#D8C8B9] bg-[#F7F3ED] px-4 py-3.5 text-sm text-[#33251F] outline-none transition focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
                >
                    <option value="" disabled>Select owner</option>
                    <option v-for="o in owners" :key="o.id" :value="o.id">
                        {{ o.name }}
                    </option>
                </select>
                <p
                    v-if="owners.length === 0"
                    class="mt-3 rounded-xl bg-[#EAE0D4] px-4 py-3 text-sm leading-relaxed text-[#76665C]"
                >
                    All existing owners already have a shop. Create a new owner
                    to assign a new shop.
                </p>
                <div
                    v-if="form.errors.owner_id"
                    class="mt-2 text-sm text-[#A33D36]"
                >
                    {{ form.errors.owner_id }}
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
