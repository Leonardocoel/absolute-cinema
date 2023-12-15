<script setup>
import { ref } from "vue";

import SidebarLink from "@/Components/SidebarLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationSidebar = ref(true);
</script>

<template>
    <header
        class="fixed top-0 z-50 w-full h-12 bg-gray-800 border-b border-gray-700"
    >
        <div class="flex pt-2 mx-1 justify-between">
            <button
                @click="showingNavigationSidebar = !showingNavigationSidebar"
                type="button"
                class="flex items-center px-1 text-sm text-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            >
                <span class="sr-only">Toggle sidebar</span>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5"
                    />
                </svg>
            </button>

            <div
                class="ml-1 text-white text-center transition duration-150 ease-in-out"
                :class="showingNavigationSidebar ? 'sm:ml-60' : 'sm:ml-12'"
            >
                <h3 class="mt-1">{{ "|" }}</h3>
            </div>

            <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="flex items-center text-sm p-1 text-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="w-6 h-6 mr-1"
                >
                    <path
                        fill-rule="evenodd"
                        d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm5.03 4.72a.75.75 0 010 1.06l-1.72 1.72h10.94a.75.75 0 010 1.5H10.81l1.72 1.72a.75.75 0 11-1.06 1.06l-3-3a.75.75 0 010-1.06l3-3a.75.75 0 011.06 0z"
                        clip-rule="evenodd"
                    />
                </svg>
                <span class="hidden sm:block">Logout</span>
            </Link>
        </div>
    </header>

    <aside
        v-show="showingNavigationSidebar"
        class="fixed top-12 left-0 z-40 w-screen sm:w-48 2xl:w-60 h-screen bg-gray-800 border-gray-200"
        aria-label="Sidebar"
    >
        <div class="h-full bg-gray-800">
            <Link :href="'/'" class="flex justify-center">
                <img src="/logo.svg" class="w-60" alt="Logo" />
                <span
                    class="self-center text-xl font-semibold whitespace-nowrap text-white"
                ></span>
            </Link>

            <ul class="space-y-2 text-lg">
                <li>
                    <SidebarLink
                        :href="route('dashboard')"
                        class="justify-center sm:justify-start"
                        :active="$page.url === '/dashboard'"
                    >
                        <svg
                            class="w-5 h-5 text-indigo-500"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 22 21"
                        >
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"
                            />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"
                            />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </SidebarLink>
                </li>
                <li>
                    <SidebarLink
                        :href="'/usuarios'"
                        :active="$page.url === '/usuarios'"
                        class="justify-center sm:justify-start"
                    >
                        <svg
                            class="w-5 h-5 text-gray-500 text-green-600"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 20 18"
                        >
                            <path
                                d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"
                            />
                        </svg>
                        <span class="ms-3">Usuários</span>
                    </SidebarLink>
                </li>
                <li>
                    <SidebarLink
                        :href="'/cinemas'"
                        :active="$page.url === '/cinemas'"
                        class="justify-center sm:justify-start"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-gray-500 text-yellow-500"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"
                            />
                        </svg>

                        <span class="ms-3">Cinema</span>
                    </SidebarLink>
                </li>
            </ul>
        </div>
    </aside>

    <div class="h-screen">
        <main
            class="pt-12"
            :class="showingNavigationSidebar && '2xl:ml-60 sm:ml-48'"
        >
            <!-- <span>{{ $page.component }}</span> -->
            <slot></slot>
        </main>
    </div>
</template>
