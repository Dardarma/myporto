<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, BriefcaseBusiness, Folder, GraduationCap, Image, Medal, Settings, UserRound } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Profile',
        href: '/admin/portfolio/profiles',
        icon: UserRound,
    },
    {
        title: 'About',
        href: '/admin/portfolio/about-items',
        icon: BookOpen,
    },
    {
        title: 'Education',
        href: '/admin/portfolio/educations',
        icon: GraduationCap,
    },
    {
        title: 'Experience',
        href: '/admin/portfolio/experiences',
        icon: BriefcaseBusiness,
    },
    {
        title: 'Certificates',
        href: '/admin/portfolio/certificates',
        icon: Medal,
    },
    {
        title: 'Projects',
        href: '/admin/portfolio/projects',
        icon: Folder,
    },
    {
        title: 'Gallery',
        href: '/admin/portfolio/gallery-items',
        icon: Image,
    },
    {
        title: 'Settings',
        href: '/admin/portfolio/site-settings',
        icon: Settings,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Public Portfolio',
        href: '/',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link href="/admin/portfolio/profiles">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
