import { Head } from '@inertiajs/react';

import HeadingSmall from '@/components/heading-small';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: '/settings/appearance',
    },
];

export default function Appearance() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Appearance settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall title="Appearance settings" description="Dark mode is now permanently enabled for the optimal space experience" />
                    <div className="rounded-lg border bg-card p-6">
                        <div className="space-y-4">
                            <div className="flex items-center space-x-3">
                                <div className="h-4 w-4 rounded-full bg-primary"></div>
                                <span className="text-sm font-medium">Dark Mode</span>
                                <span className="text-xs text-muted-foreground">(Always Active)</span>
                            </div>
                            <p className="text-sm text-muted-foreground">
                                🌌 Experience Postaverse in its intended dark, space-themed environment. 
                                The cosmic interface is designed for optimal viewing in dark mode.
                            </p>
                        </div>
                    </div>
                </div>
            </SettingsLayout>
        </AppLayout>
    );
}