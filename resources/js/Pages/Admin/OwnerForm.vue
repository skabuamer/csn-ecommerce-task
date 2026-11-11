<script setup>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "../../Layouts/AppLayout.vue";

const props = defineProps({ owner: Object });

const form = useForm({
    name: props.owner?.name ?? "",
    email: props.owner?.email ?? "",
    phone: props.owner?.phone ?? "",
    password: "",
});

function submit() {
    if (props.owner) {
        form.put(`/admin/owners/${props.owner.id}`);
    } else {
        form.post("/admin/owners");
    }
}
</script>

<template>
    <AppLayout>
        <h1
            class="mb-8 font-serif text-4xl font-bold tracking-tight text-[#33251F] md:text-5xl"
        >
            {{ owner ? "Edit" : "New" }}
            <span class="font-normal italic text-[#9A493B]">Owner</span>
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
                <input
                    v-model="form.email"
                    type="email"
                    placeholder="Email"
                    class="w-full rounded-xl border border-[#D8C8B9] bg-[#F7F3ED] px-4 py-3.5 text-sm text-[#33251F] outline-none transition placeholder:text-[#A69588] focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
                />
                <div
                    v-if="form.errors.email"
                    class="mt-2 text-sm text-[#A33D36]"
                >
                    {{ form.errors.email }}
                </div>
            </div>

            <div>
                <input
                    v-model="form.phone"
                    type="tel"
                    placeholder="Phone"
                    class="w-full rounded-xl border border-[#D8C8B9] bg-[#F7F3ED] px-4 py-3.5 text-sm text-[#33251F] outline-none transition placeholder:text-[#A69588] focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
                />
                <div
                    v-if="form.errors.phone"
                    class="mt-2 text-sm text-[#A33D36]"
                >
                    {{ form.errors.phone }}
                </div>
            </div>

            <div>
                <input
                    v-model="form.password"
                    type="password"
                    :placeholder="
                        owner
                            ? 'Leave Blank to keep current password'
                            : 'Set Password'
                    "
                    class="w-full rounded-xl border border-[#D8C8B9] bg-[#F7F3ED] px-4 py-3.5 text-sm text-[#33251F] outline-none transition placeholder:text-[#A69588] focus:border-[#9A493B] focus:ring-2 focus:ring-[#9A493B]/10"
                />
                <div
                    v-if="form.errors.password"
                    class="mt-2 text-sm text-[#A33D36]"
                >
                    {{ form.errors.password }}
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
