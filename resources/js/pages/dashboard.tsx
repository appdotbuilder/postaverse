import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'News Feed',
        href: '/dashboard',
    },
];

interface Post {
    id: number;
    content: string;
    media: string[] | null;
    privacy: string;
    likes_count: number;
    comments_count: number;
    shares_count: number;
    created_at: string;
    user: {
        id: number;
        name: string;
        username: string | null;
        avatar: string | null;
    };
    comments: Array<{
        id: number;
        content: string;
        created_at: string;
        user: {
            id: number;
            name: string;
            username: string | null;
        };
    }>;
}

interface DashboardProps {
    posts?: Post[];
    [key: string]: unknown;
}

export default function Dashboard({ posts = [] }: DashboardProps) {
    const { auth } = usePage<SharedData>().props;
    const [newPostContent, setNewPostContent] = useState('');
    const [newPostPrivacy, setNewPostPrivacy] = useState('public');

    const handleCreatePost = (e: React.FormEvent) => {
        e.preventDefault();
        if (!newPostContent.trim()) return;

        router.post('/posts', {
            content: newPostContent,
            privacy: newPostPrivacy
        }, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                setNewPostContent('');
                setNewPostPrivacy('public');
            }
        });
    };

    const handleLikePost = (postId: number) => {
        router.post(`/posts/${postId}/like`, {}, {
            preserveState: true,
            preserveScroll: true
        });
    };

    const formatDate = (dateString: string) => {
        const date = new Date(dateString);
        const now = new Date();
        const diffInHours = (now.getTime() - date.getTime()) / (1000 * 60 * 60);

        if (diffInHours < 1) {
            return `${Math.floor(diffInHours * 60)}m ago`;
        } else if (diffInHours < 24) {
            return `${Math.floor(diffInHours)}h ago`;
        } else {
            return `${Math.floor(diffInHours / 24)}d ago`;
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="News Feed - Postaverse" />
            
            <div className="max-w-2xl mx-auto p-6 space-y-6">
                {/* Create Post Card */}
                <div className="bg-white rounded-xl shadow-lg p-6 dark:bg-gray-800">
                    <h2 className="text-lg font-semibold mb-4 flex items-center gap-2">
                        ✨ What's on your mind, {auth.user?.name}?
                    </h2>
                    <form onSubmit={handleCreatePost} className="space-y-4">
                        <div>
                            <textarea
                                value={newPostContent}
                                onChange={(e) => setNewPostContent(e.target.value)}
                                placeholder="Share your thoughts, experiences, or ask a question..."
                                className="w-full p-4 border border-gray-200 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                rows={4}
                                maxLength={10000}
                            />
                            <div className="text-sm text-gray-500 mt-2">
                                {newPostContent.length}/10,000 characters
                            </div>
                        </div>
                        
                        <div className="flex items-center justify-between">
                            <select
                                value={newPostPrivacy}
                                onChange={(e) => setNewPostPrivacy(e.target.value)}
                                className="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                                <option value="public">🌍 Public</option>
                                <option value="friends">👥 Friends</option>
                                <option value="private">🔒 Private</option>
                            </select>
                            
                            <button
                                type="submit"
                                disabled={!newPostContent.trim()}
                                className="px-6 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                            >
                                📤 Share
                            </button>
                        </div>
                    </form>
                </div>

                {/* Quick Actions */}
                <div className="grid md:grid-cols-3 gap-4">
                    <Link
                        href="/groups"
                        className="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-xl p-4 text-center hover:from-purple-600 hover:to-purple-700 transition-all duration-200 transform hover:scale-105"
                    >
                        <div className="text-2xl mb-2">👥</div>
                        <div className="font-medium">Explore Groups</div>
                    </Link>
                    
                    <Link
                        href="/messages"
                        className="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl p-4 text-center hover:from-blue-600 hover:to-blue-700 transition-all duration-200 transform hover:scale-105"
                    >
                        <div className="text-2xl mb-2">💬</div>
                        <div className="font-medium">Messages</div>
                    </Link>
                    
                    <Link
                        href="/profile/edit"
                        className="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-4 text-center hover:from-green-600 hover:to-green-700 transition-all duration-200 transform hover:scale-105"
                    >
                        <div className="text-2xl mb-2">👤</div>
                        <div className="font-medium">Edit Profile</div>
                    </Link>
                </div>

                {/* Posts Feed */}
                <div className="space-y-6">
                    {posts.length === 0 ? (
                        <div className="bg-white rounded-xl shadow-lg p-12 text-center dark:bg-gray-800">
                            <div className="text-6xl mb-4">🌟</div>
                            <h3 className="text-xl font-semibold mb-2">Welcome to Postaverse!</h3>
                            <p className="text-gray-600 dark:text-gray-300 mb-6">
                                Your news feed is empty. Start by creating your first post above, or explore groups and follow other users to see their content here.
                            </p>
                            <div className="flex gap-4 justify-center">
                                <Link
                                    href="/groups"
                                    className="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200"
                                >
                                    🔍 Discover Groups
                                </Link>
                                <Link
                                    href="/users"
                                    className="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200"
                                >
                                    👥 Find People
                                </Link>
                            </div>
                        </div>
                    ) : (
                        posts.map((post) => (
                            <article key={post.id} className="bg-white rounded-xl shadow-lg p-6 dark:bg-gray-800">
                                {/* Post Header */}
                                <div className="flex items-center gap-3 mb-4">
                                    <div className="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        {post.user.avatar ? (
                                            <img
                                                src={post.user.avatar}
                                                alt={post.user.name}
                                                className="w-full h-full rounded-full object-cover"
                                            />
                                        ) : (
                                            post.user.name.charAt(0).toUpperCase()
                                        )}
                                    </div>
                                    <div className="flex-1">
                                        <Link
                                            href={`/users/${post.user.id}`}
                                            className="font-semibold hover:text-blue-600 transition-colors duration-200"
                                        >
                                            {post.user.name}
                                        </Link>
                                        {post.user.username && (
                                            <div className="text-sm text-gray-500">@{post.user.username}</div>
                                        )}
                                    </div>
                                    <div className="text-sm text-gray-500">
                                        {formatDate(post.created_at)}
                                    </div>
                                </div>

                                {/* Post Content */}
                                <div className="mb-4">
                                    <p className="text-gray-800 dark:text-gray-200 whitespace-pre-wrap leading-relaxed">
                                        {post.content}
                                    </p>
                                </div>

                                {/* Post Media */}
                                {post.media && post.media.length > 0 && (
                                    <div className="mb-4 grid grid-cols-2 gap-2">
                                        {post.media.slice(0, 4).map((mediaUrl, index) => (
                                            <div key={index} className="relative">
                                                <img
                                                    src={mediaUrl}
                                                    alt="Post media"
                                                    className="w-full h-48 object-cover rounded-lg"
                                                />
                                                {index === 3 && post.media && post.media.length > 4 && (
                                                    <div className="absolute inset-0 bg-black bg-opacity-50 rounded-lg flex items-center justify-center text-white font-semibold">
                                                        +{post.media.length - 4} more
                                                    </div>
                                                )}
                                            </div>
                                        ))}
                                    </div>
                                )}

                                {/* Post Actions */}
                                <div className="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <div className="flex items-center gap-6">
                                        <button
                                            onClick={() => handleLikePost(post.id)}
                                            className="flex items-center gap-2 text-gray-600 hover:text-red-600 transition-colors duration-200 dark:text-gray-400 dark:hover:text-red-400"
                                        >
                                            ❤️ <span>{post.likes_count}</span>
                                        </button>
                                        
                                        <Link
                                            href={`/posts/${post.id}`}
                                            className="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors duration-200 dark:text-gray-400 dark:hover:text-blue-400"
                                        >
                                            💬 <span>{post.comments_count}</span>
                                        </Link>
                                        
                                        <button className="flex items-center gap-2 text-gray-600 hover:text-green-600 transition-colors duration-200 dark:text-gray-400 dark:hover:text-green-400">
                                            🔄 <span>{post.shares_count}</span>
                                        </button>
                                    </div>
                                    
                                    <div className="text-xs text-gray-500 flex items-center gap-1">
                                        {post.privacy === 'public' && '🌍'}
                                        {post.privacy === 'friends' && '👥'}
                                        {post.privacy === 'private' && '🔒'}
                                        {post.privacy.charAt(0).toUpperCase() + post.privacy.slice(1)}
                                    </div>
                                </div>

                                {/* Recent Comments Preview */}
                                {post.comments.length > 0 && (
                                    <div className="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                        <div className="space-y-3">
                                            {post.comments.slice(0, 2).map((comment) => (
                                                <div key={comment.id} className="flex items-start gap-2">
                                                    <div className="w-6 h-6 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                                        {comment.user.name.charAt(0).toUpperCase()}
                                                    </div>
                                                    <div className="flex-1">
                                                        <div className="bg-gray-50 rounded-lg p-3 dark:bg-gray-700">
                                                            <div className="text-sm font-medium mb-1">
                                                                {comment.user.name}
                                                            </div>
                                                            <div className="text-sm text-gray-700 dark:text-gray-300">
                                                                {comment.content}
                                                            </div>
                                                        </div>
                                                        <div className="text-xs text-gray-500 mt-1 ml-3">
                                                            {formatDate(comment.created_at)}
                                                        </div>
                                                    </div>
                                                </div>
                                            ))}
                                            {post.comments.length > 2 && (
                                                <Link
                                                    href={`/posts/${post.id}`}
                                                    className="text-sm text-blue-600 hover:text-blue-700 ml-8 dark:text-blue-400 dark:hover:text-blue-300"
                                                >
                                                    View all {post.comments.length} comments
                                                </Link>
                                            )}
                                        </div>
                                    </div>
                                )}
                            </article>
                        ))
                    )}
                </div>
            </div>
        </AppLayout>
    );
}