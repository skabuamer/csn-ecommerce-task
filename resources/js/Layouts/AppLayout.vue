<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const user = computed(() => page.props.auth.user);
const flash = computed(() => page.props.flash);
</script>

<template>
    <div
        class="min-h-screen bg-[#F5F0E8] text-[#211C1A] selection:bg-[#B7472A] selection:text-white"
    >
        <!-- Navigation -->
        <nav
            class="relative z-10 border-b-2 border-[#211C1A] bg-[#F5F0E8] px-6 py-5 lg:px-12"
        >
            <div
                class="mx-auto flex max-w-[1600px] flex-wrap items-center gap-6"
            >
                <Link
                    href="/"
                    class="mr-6 text-2xl font-black uppercase tracking-tighter text-[#8D2929]"
                >
                    Marketplace<span class="text-[#D66A35]">.</span>
                </Link>

                <div
                    class="flex flex-wrap items-center gap-x-7 gap-y-3 text-sm font-bold uppercase tracking-wider"
                >
                    <Link
                        href="/"
                        class="transition-colors hover:text-[#B7472A]"
                    >
                        Home
                    </Link>

                    <template v-if="user?.role === 'admin'">
                        <Link
                            href="/admin/shops"
                            class="transition-colors hover:text-[#B7472A]"
                        >
                            Shops
                        </Link>
                        <Link
                            href="/admin/products"
                            class="transition-colors hover:text-[#B7472A]"
                        >
                            Products
                        </Link>
                        <Link
                            href="/admin/owners"
                            class="transition-colors hover:text-[#B7472A]"
                        >
                            Owners
                        </Link>
                    </template>

                    <template v-if="user?.role === 'shop_owner'">
                        <Link
                            href="/owner/catalog"
                            class="transition-colors hover:text-[#B7472A]"
                        >
                            Catalog
                        </Link>
                        <Link
                            href="/owner/listings"
                            class="transition-colors hover:text-[#B7472A]"
                        >
                            My Listings
                        </Link>
                    </template>
                </div>

                <div class="ml-auto flex items-center gap-5">
                    <template v-if="user">
                        <span
                            class="hidden text-sm font-bold tracking-wide text-[#665C55] sm:block"
                        >
                            {{ user.name }}
                        </span>
                        <button
                            @click="router.post('/logout')"
                            class="border-2 border-[#211C1A] bg-[#211C1A] px-5 py-2.5 text-xs font-black uppercase tracking-widest text-[#F5F0E8] transition-all hover:border-[#B7472A] hover:bg-[#B7472A]"
                        >
                            Logout
                        </button>
                    </template>
                    <Link
                        v-else
                        href="/login"
                        class="border-2 border-[#211C1A] px-6 py-2.5 text-xs font-black uppercase tracking-widest transition-all hover:bg-[#211C1A] hover:text-[#F5F0E8]"
                    >
                        Login
                    </Link>
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        <div
            v-if="flash.success"
            class="border-b-2 border-[#315B3B] bg-[#DDE8D9] px-6 py-4 font-bold text-[#315B3B] lg:px-12"
        >
            {{ flash.success }}
        </div>

        <div
            v-if="flash.error"
            class="border-b-2 border-[#8D2929] bg-[#F3DEDA] px-6 py-4 font-bold text-[#8D2929] lg:px-12"
        >
            {{ flash.error }}
        </div>

        <!-- Main Content -->
        <main
            class="mx-auto min-h-[calc(100vh-100px)] max-w-[1600px] px-6 py-10 lg:px-12 lg:py-14"
        >
            <slot />
        </main>
    </div>
</template>
