<script setup>
import { ref, computed } from "vue";

import SidebarLink from "@/Components/SidebarLink.vue";
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();

const user = computed(() => page.props.auth.user);
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
                <select
                    name="cinemas"
                    id="cinema"
                    class="bg-transparent py-0 border-none"
                    :class="{ 'cursor-pointer': user.cinemas.length > 1 }"
                    :disabled="user.cinemas.length <= 1"
                >
                    <option v-for="cinema of user.cinemas" :value="cinema.id">
                        {{ cinema.name }}
                    </option>
                </select>
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
                        :href="'/cinema/dashboard'"
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
                        href="/cinema/perfil"
                        :active="$page.url === '/cinema/perfil'"
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

                    <ul>
                        <li>
                            <!-- :href="`/cinema/sessoes`" -->
                            <SidebarLink
                                :active="$page.url === `/cinema/sessoes`"
                                class="justify-center"
                            >
                                <span class="">Sessões</span>
                            </SidebarLink>
                        </li>
                        <li>
                            <!-- :href="`/cinema/horarios`" -->
                            <SidebarLink
                                :active="
                                    $page.url === `/cinema/cinemas/horarios}`
                                "
                                class="justify-center"
                            >
                                <span class="">Horários</span>
                            </SidebarLink>
                        </li>
                        <li>
                            <!-- :href="`/cinema/salas`" -->
                            <SidebarLink
                                :active="$page.url === `/cinema/cinemas/salas`"
                                class="justify-center"
                            >
                                <span class="md:mr-7">Salas</span>
                            </SidebarLink>
                        </li>
                        <li>
                            <!-- :href="`/cinema/tickets`" -->
                            <SidebarLink
                                :active="$page.url === `/cinema/tickets}`"
                                class="justify-center"
                            >
                                <span class="md:mr-3">Tickets</span>
                            </SidebarLink>
                        </li>
                    </ul>
                </li>
                <li>
                    <SidebarLink
                        :href="'/cinema/usuarios'"
                        :active="$page.url === '/cinema/usuarios'"
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
                        :href="'/cinema/filmes'"
                        :active="$page.url === '/cinema/filmes'"
                        class="justify-center sm:justify-start"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-gray-500 text-red-500"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0118 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0118 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 016 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 1.125-1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0-.621.504-1.125 1.125-1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 1.125M6 13.125C6 12.504 5.496 12 4.875 12m-1.5 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M19.125 12h1.5m0 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h1.5m14.25 0h1.5"
                            />
                        </svg>

                        <span class="ms-3">Filmes</span>
                    </SidebarLink>
                </li>
            </ul>
        </div>
    </aside>

    <main
        class="h-screen pt-12"
        :class="showingNavigationSidebar && '2xl:pl-60 sm:pl-48'"
    >
        <slot></slot>
    </main>
</template>
