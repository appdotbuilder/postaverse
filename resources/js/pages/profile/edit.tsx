import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Profile', href: '/profile' },
    { title: 'Edit', href: '/profile/edit' },
];

export default function EditProfile() {
    const { auth } = usePage<SharedData>().props;
    const user = auth.user;

    const { data, setData, patch, processing, errors } = useForm({
        name: user?.name || '',
        username: user?.username || '',
        email: user?.email || '',
        bio: user?.bio || '',
        location: user?.location || '',
        website: user?.website || '',
        privacy: user?.privacy || 'public',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        patch('/profile');
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Edit Profile - Postaverse" />
            
            <div className="max-w-2xl mx-auto p-6">
                <div className="bg-white rounded-xl shadow-lg p-8 dark:bg-gray-800">
                    <div className="flex items-center gap-4 mb-8">
                        <div className="w-16 h-16 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                            {user?.name?.charAt(0).toUpperCase()}
                        </div>
                        <div>
                            <h1 className="text-2xl font-bold">✏️ Edit Profile</h1>
                            <p className="text-gray-600 dark:text-gray-400">Update your personal information</p>
                        </div>
                    </div>

                    <form onSubmit={handleSubmit} className="space-y-6">
                        <div className="grid md:grid-cols-2 gap-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">
                                    👤 Full Name
                                </label>
                                <input
                                    type="text"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    className="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required
                                />
                                {errors.name && <p className="text-red-500 text-sm mt-1">{errors.name}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">
                                    🏷️ Username
                                </label>
                                <div className="relative">
                                    <input
                                        type="text"
                                        value={data.username}
                                        onChange={(e) => setData('username', e.target.value)}
                                        className="w-full px-4 py-3 pl-8 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="username"
                                    />
                                    <span className="absolute left-3 top-3 text-gray-400">@</span>
                                </div>
                                {errors.username && <p className="text-red-500 text-sm mt-1">{errors.username}</p>}
                            </div>
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">
                                📧 Email Address
                            </label>
                            <input
                                type="email"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                className="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                required
                            />
                            {errors.email && <p className="text-red-500 text-sm mt-1">{errors.email}</p>}
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">
                                ✨ Bio
                            </label>
                            <textarea
                                value={data.bio}
                                onChange={(e) => setData('bio', e.target.value)}
                                placeholder="Tell people about yourself..."
                                className="w-full px-4 py-3 border border-gray-200 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                rows={4}
                                maxLength={500}
                            />
                            <div className="text-sm text-gray-500 mt-1">
                                {data.bio.length}/500 characters
                            </div>
                            {errors.bio && <p className="text-red-500 text-sm mt-1">{errors.bio}</p>}
                        </div>

                        <div className="grid md:grid-cols-2 gap-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">
                                    📍 Location
                                </label>
                                <input
                                    type="text"
                                    value={data.location}
                                    onChange={(e) => setData('location', e.target.value)}
                                    placeholder="City, Country"
                                    className="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                />
                                {errors.location && <p className="text-red-500 text-sm mt-1">{errors.location}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">
                                    🌐 Website
                                </label>
                                <input
                                    type="url"
                                    value={data.website}
                                    onChange={(e) => setData('website', e.target.value)}
                                    placeholder="https://yourwebsite.com"
                                    className="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                />
                                {errors.website && <p className="text-red-500 text-sm mt-1">{errors.website}</p>}
                            </div>
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">
                                🔒 Privacy Setting
                            </label>
                            <select
                                value={data.privacy}
                                onChange={(e) => setData('privacy', e.target.value)}
                                className="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                                <option value="public">🌍 Public - Anyone can see your profile</option>
                                <option value="private">🔒 Private - Only approved followers can see your posts</option>
                            </select>
                            {errors.privacy && <p className="text-red-500 text-sm mt-1">{errors.privacy}</p>}
                        </div>

                        <div className="bg-blue-50 rounded-lg p-4 dark:bg-blue-900/20">
                            <h3 className="font-medium text-blue-900 mb-2 dark:text-blue-200">📸 Profile Photos (Coming Soon)</h3>
                            <p className="text-sm text-blue-700 dark:text-blue-300">
                                Avatar and cover photo uploads will be available in a future update.
                            </p>
                        </div>

                        <div className="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <Button
                                type="submit"
                                disabled={processing}
                                className="px-8 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                            >
                                {processing ? '💾 Saving...' : '✨ Save Changes'}
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </AppLayout>
    );
}