import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Groups', href: '/groups' },
];

interface Group {
    id: number;
    name: string;
    description: string;
    cover_image: string | null;
    privacy: string;
    members_count: number;
    is_active: boolean;
    creator: {
        id: number;
        name: string;
    };
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginationMeta {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

interface GroupsIndexProps {
    groups: {
        data: Group[];
        links: PaginationLink[];
        meta: PaginationMeta;
    };
    [key: string]: unknown;
}

export default function GroupsIndex({ groups }: GroupsIndexProps) {
    const getPrivacyIcon = (privacy: string) => {
        switch (privacy) {
            case 'public': return '🌍';
            case 'private': return '🔒';
            case 'secret': return '🤫';
            default: return '👥';
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Groups - Postaverse" />
            
            <div className="max-w-6xl mx-auto p-6">
                <div className="flex items-center justify-between mb-8">
                    <div>
                        <h1 className="text-3xl font-bold flex items-center gap-3">
                            👥 Discover Groups
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400 mt-2">
                            Join communities that match your interests and passions
                        </p>
                    </div>
                    <Link
                        href="/groups/create"
                        className="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium"
                    >
                        ✨ Create Group
                    </Link>
                </div>

                {groups.data.length === 0 ? (
                    <div className="bg-white rounded-xl shadow-lg p-12 text-center dark:bg-gray-800">
                        <div className="text-6xl mb-4">🌟</div>
                        <h3 className="text-xl font-semibold mb-2">No Groups Yet</h3>
                        <p className="text-gray-600 dark:text-gray-300 mb-6">
                            Be the first to create a community on Postaverse!
                        </p>
                        <Link
                            href="/groups/create"
                            className="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200"
                        >
                            🚀 Create First Group
                        </Link>
                    </div>
                ) : (
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {groups.data.map((group) => (
                            <div key={group.id} className="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 dark:bg-gray-800">
                                <div className="relative h-48">
                                    {group.cover_image ? (
                                        <img
                                            src={group.cover_image}
                                            alt={group.name}
                                            className="w-full h-full object-cover"
                                        />
                                    ) : (
                                        <div className="w-full h-full bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center">
                                            <div className="text-4xl text-white">👥</div>
                                        </div>
                                    )}
                                    <div className="absolute top-4 left-4 bg-white bg-opacity-90 rounded-full px-3 py-1 text-sm font-medium dark:bg-gray-800 dark:bg-opacity-90">
                                        {getPrivacyIcon(group.privacy)} {group.privacy.charAt(0).toUpperCase() + group.privacy.slice(1)}
                                    </div>
                                </div>
                                
                                <div className="p-6">
                                    <h3 className="text-xl font-bold mb-2 line-clamp-1">
                                        {group.name}
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-300 mb-4 line-clamp-2 leading-relaxed">
                                        {group.description}
                                    </p>
                                    
                                    <div className="flex items-center justify-between text-sm text-gray-500 mb-4">
                                        <span className="flex items-center gap-1">
                                            👤 Created by {group.creator.name}
                                        </span>
                                    </div>
                                    
                                    <div className="flex items-center justify-between">
                                        <span className="text-sm text-gray-600 flex items-center gap-1 dark:text-gray-400">
                                            👥 {group.members_count.toLocaleString()} members
                                        </span>
                                        <Link
                                            href={`/groups/${group.id}`}
                                            className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm font-medium"
                                        >
                                            View Group
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                )}

                {/* Pagination */}
                {groups.links && (
                    <div className="mt-8 flex justify-center">
                        <nav className="flex items-center gap-2">
                            {groups.links.map((link, index: number) => (
                                <Link
                                    key={index}
                                    href={link.url || '#'}
                                    className={`px-3 py-2 rounded-lg text-sm ${
                                        link.active
                                            ? 'bg-blue-600 text-white'
                                            : 'bg-white text-gray-600 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700'
                                    } ${!link.url ? 'opacity-50 cursor-not-allowed' : ''}`}
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                />
                            ))}
                        </nav>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}