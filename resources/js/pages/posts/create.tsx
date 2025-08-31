import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, router, usePage, useForm } from '@inertiajs/react';
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Create Post', href: '/posts/create' },
];

export default function CreatePost() {
    const { auth } = usePage<SharedData>().props;
    const { data, setData, post, processing, errors } = useForm({
        content: '',
        privacy: 'public',
        media: []
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/posts');
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Post - Postaverse" />
            
            <div className="max-w-2xl mx-auto p-6">
                <div className="bg-white rounded-xl shadow-lg p-8 dark:bg-gray-800">
                    <div className="flex items-center gap-4 mb-6">
                        <div className="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {auth.user?.name?.charAt(0).toUpperCase()}
                        </div>
                        <div>
                            <h1 className="text-2xl font-bold">✨ Create New Post</h1>
                            <p className="text-gray-600 dark:text-gray-400">Share your thoughts with the world</p>
                        </div>
                    </div>

                    <form onSubmit={handleSubmit} className="space-y-6">
                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">
                                📝 What's on your mind?
                            </label>
                            <textarea
                                value={data.content}
                                onChange={(e) => setData('content', e.target.value)}
                                placeholder="Share your thoughts, experiences, or ask a question..."
                                className="w-full p-4 border border-gray-200 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                rows={8}
                                maxLength={10000}
                                required
                            />
                            <div className="flex justify-between text-sm text-gray-500 mt-2">
                                <span>{data.content.length}/10,000 characters</span>
                                {errors.content && <span className="text-red-500">{errors.content}</span>}
                            </div>
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">
                                🔒 Privacy Setting
                            </label>
                            <select
                                value={data.privacy}
                                onChange={(e) => setData('privacy', e.target.value)}
                                className="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                                <option value="public">🌍 Public - Anyone can see this post</option>
                                <option value="friends">👥 Friends - Only your followers can see</option>
                                <option value="private">🔒 Private - Only you can see</option>
                            </select>
                            {errors.privacy && <p className="text-red-500 text-sm mt-1">{errors.privacy}</p>}
                        </div>

                        <div className="bg-blue-50 rounded-lg p-4 dark:bg-blue-900/20">
                            <h3 className="font-medium text-blue-900 mb-2 dark:text-blue-200">📸 Media Upload (Coming Soon)</h3>
                            <p className="text-sm text-blue-700 dark:text-blue-300">
                                Photo and video uploads will be available in a future update. For now, you can share links to external media in your post content.
                            </p>
                        </div>

                        <div className="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button
                                type="button"
                                onClick={() => router.visit('/dashboard')}
                                className="px-6 py-2 text-gray-600 hover:text-gray-800 transition-colors duration-200 dark:text-gray-400 dark:hover:text-gray-200"
                            >
                                Cancel
                            </button>
                            
                            <Button
                                type="submit"
                                disabled={processing || !data.content.trim()}
                                className="px-8 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                            >
                                {processing ? '📤 Sharing...' : '🚀 Share Post'}
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </AppLayout>
    );
}