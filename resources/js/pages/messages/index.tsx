import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Messages', href: '/messages' },
];

interface Message {
    id: number;
    content: string;
    is_read: boolean;
    created_at: string;
    sender: {
        id: number;
        name: string;
        username: string | null;
        avatar: string | null;
    };
    recipient: {
        id: number;
        name: string;
        username: string | null;
        avatar: string | null;
    };
}

interface MessagesIndexProps {
    conversations: Message[];
    [key: string]: unknown;
}

export default function MessagesIndex({ conversations }: MessagesIndexProps) {
    const { auth } = usePage<SharedData>().props;

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

    const getOtherUser = (message: Message) => {
        return message.sender.id === auth.user?.id ? message.recipient : message.sender;
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Messages - Postaverse" />
            
            <div className="max-w-4xl mx-auto p-6">
                <div className="bg-white rounded-xl shadow-lg dark:bg-gray-800">
                    <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h1 className="text-2xl font-bold flex items-center gap-3">
                            💬 Messages
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400 mt-1">
                            Your conversations with other users
                        </p>
                    </div>

                    <div className="divide-y divide-gray-200 dark:divide-gray-700">
                        {conversations.length === 0 ? (
                            <div className="p-12 text-center">
                                <div className="text-6xl mb-4">💬</div>
                                <h3 className="text-xl font-semibold mb-2">No Messages Yet</h3>
                                <p className="text-gray-600 dark:text-gray-300 mb-6">
                                    Start a conversation with someone from your network!
                                </p>
                                <Link
                                    href="/dashboard"
                                    className="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200"
                                >
                                    🔍 Explore Feed
                                </Link>
                            </div>
                        ) : (
                            conversations.map((message) => {
                                const otherUser = getOtherUser(message);
                                const isUnread = message.recipient.id === auth.user?.id && !message.is_read;
                                
                                return (
                                    <Link
                                        key={`${message.sender.id}-${message.recipient.id}`}
                                        href={`/messages/${otherUser.id}`}
                                        className="block p-4 hover:bg-gray-50 transition-colors duration-200 dark:hover:bg-gray-700"
                                    >
                                        <div className="flex items-center gap-4">
                                            <div className="relative">
                                                <div className="w-12 h-12 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                                    {otherUser.avatar ? (
                                                        <img
                                                            src={otherUser.avatar}
                                                            alt={otherUser.name}
                                                            className="w-full h-full rounded-full object-cover"
                                                        />
                                                    ) : (
                                                        otherUser.name.charAt(0).toUpperCase()
                                                    )}
                                                </div>
                                                {isUnread && (
                                                    <div className="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full"></div>
                                                )}
                                            </div>
                                            
                                            <div className="flex-1 min-w-0">
                                                <div className="flex items-center justify-between">
                                                    <h3 className={`font-medium truncate ${isUnread ? 'font-bold' : ''}`}>
                                                        {otherUser.name}
                                                    </h3>
                                                    <span className="text-sm text-gray-500 flex-shrink-0">
                                                        {formatDate(message.created_at)}
                                                    </span>
                                                </div>
                                                
                                                {otherUser.username && (
                                                    <p className="text-sm text-gray-500 truncate">
                                                        @{otherUser.username}
                                                    </p>
                                                )}
                                                
                                                <p className={`text-sm truncate mt-1 ${
                                                    isUnread ? 'font-semibold text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400'
                                                }`}>
                                                    {message.sender.id === auth.user?.id && (
                                                        <span className="text-gray-400">You: </span>
                                                    )}
                                                    {message.content}
                                                </p>
                                            </div>
                                            
                                            <div className="flex-shrink-0">
                                                {isUnread ? (
                                                    <div className="w-3 h-3 bg-blue-500 rounded-full"></div>
                                                ) : (
                                                    <div className="text-gray-400">
                                                        💬
                                                    </div>
                                                )}
                                            </div>
                                        </div>
                                    </Link>
                                );
                            })
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}