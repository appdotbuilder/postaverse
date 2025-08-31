import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="Postaverse - Connect, Share, Discover">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex min-h-screen flex-col items-center bg-gradient-to-br from-purple-50 via-blue-50 to-indigo-100 p-6 text-gray-900 lg:justify-center lg:p-8 dark:from-gray-900 dark:via-purple-900 dark:to-indigo-900 dark:text-white">
                <header className="mb-8 w-full max-w-4xl">
                    <nav className="flex items-center justify-between">
                        <div className="flex items-center gap-2">
                            <div className="h-8 w-8 rounded-full bg-gradient-to-r from-purple-500 to-blue-500"></div>
                            <span className="text-xl font-bold">Postaverse</span>
                        </div>
                        <div className="flex items-center gap-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="inline-flex items-center rounded-full bg-blue-600 px-6 py-2 text-sm font-medium text-white shadow-lg hover:bg-blue-700 transition-all duration-200"
                                >
                                    🏠 Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="inline-flex items-center rounded-full px-6 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200 dark:text-gray-300 dark:hover:text-blue-400"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="inline-flex items-center rounded-full bg-blue-600 px-6 py-2 text-sm font-medium text-white shadow-lg hover:bg-blue-700 transition-all duration-200"
                                    >
                                        Get Started
                                    </Link>
                                </>
                            )}
                        </div>
                    </nav>
                </header>

                <main className="w-full max-w-6xl">
                    {/* Hero Section */}
                    <div className="text-center mb-16">
                        <h1 className="mb-6 text-5xl font-bold bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-600 bg-clip-text text-transparent lg:text-7xl">
                            🌟 Welcome to Postaverse
                        </h1>
                        <p className="mb-8 text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed dark:text-gray-300">
                            The next generation social media platform where connections thrive, creativity flows, and communities flourish. Share your world, discover amazing content, and build meaningful relationships.
                        </p>
                        {!auth.user && (
                            <div className="flex gap-4 justify-center">
                                <Link
                                    href={route('register')}
                                    className="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-purple-600 to-blue-600 px-8 py-4 text-lg font-semibold text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300"
                                >
                                    🚀 Join Postaverse
                                </Link>
                                <Link
                                    href={route('login')}
                                    className="inline-flex items-center gap-2 rounded-full border-2 border-blue-600 px-8 py-4 text-lg font-semibold text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-300 dark:border-blue-400 dark:text-blue-400 dark:hover:bg-blue-400 dark:hover:text-white"
                                >
                                    👋 Sign In
                                </Link>
                            </div>
                        )}
                    </div>

                    {/* Features Grid */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                        <div className="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 dark:bg-gray-800">
                            <div className="text-4xl mb-4">📱</div>
                            <h3 className="text-xl font-bold mb-3">Personalized Feed</h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Discover content that matters to you with our intelligent algorithm that learns your preferences and shows you posts from people and groups you care about.
                            </p>
                        </div>

                        <div className="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 dark:bg-gray-800">
                            <div className="text-4xl mb-4">👥</div>
                            <h3 className="text-xl font-bold mb-3">Vibrant Communities</h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Create and join groups based on your interests. From photography to gaming, cooking to coding - find your tribe and share your passion.
                            </p>
                        </div>

                        <div className="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 dark:bg-gray-800">
                            <div className="text-4xl mb-4">💬</div>
                            <h3 className="text-xl font-bold mb-3">Direct Messaging</h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Stay connected with friends through our intuitive messaging system. Share photos, videos, and have meaningful conversations.
                            </p>
                        </div>

                        <div className="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 dark:bg-gray-800">
                            <div className="text-4xl mb-4">🎨</div>
                            <h3 className="text-xl font-bold mb-3">Rich Content Creation</h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Express yourself with our powerful rich text editor. Add formatting, embed media, and create posts that truly represent your voice.
                            </p>
                        </div>

                        <div className="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 dark:bg-gray-800">
                            <div className="text-4xl mb-4">📸</div>
                            <h3 className="text-xl font-bold mb-3">Media Sharing</h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Upload and share your photos and videos seamlessly. Support for multiple formats and intelligent compression for optimal viewing.
                            </p>
                        </div>

                        <div className="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 dark:bg-gray-800">
                            <div className="text-4xl mb-4">🔐</div>
                            <h3 className="text-xl font-bold mb-3">Privacy First</h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Your privacy matters. Control who sees your content with granular privacy settings and manage your digital footprint with confidence.
                            </p>
                        </div>
                    </div>

                    {/* Stats Section */}
                    <div className="bg-white rounded-3xl p-12 shadow-2xl mb-16 dark:bg-gray-800">
                        <h2 className="text-3xl font-bold text-center mb-8">Join the Growing Community</h2>
                        <div className="grid md:grid-cols-3 gap-8 text-center">
                            <div>
                                <div className="text-4xl font-bold text-blue-600 mb-2">1M+</div>
                                <div className="text-gray-600 dark:text-gray-300">Active Users</div>
                            </div>
                            <div>
                                <div className="text-4xl font-bold text-purple-600 mb-2">50K+</div>
                                <div className="text-gray-600 dark:text-gray-300">Communities</div>
                            </div>
                            <div>
                                <div className="text-4xl font-bold text-indigo-600 mb-2">10M+</div>
                                <div className="text-gray-600 dark:text-gray-300">Posts Shared</div>
                            </div>
                        </div>
                    </div>

                    {/* CTA Section */}
                    {!auth.user && (
                        <div className="text-center bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-600 rounded-3xl p-12 text-white shadow-2xl">
                            <h2 className="text-3xl font-bold mb-4">Ready to Get Started? 🌟</h2>
                            <p className="text-xl mb-8 opacity-90">
                                Join thousands of users who are already sharing, connecting, and discovering on Postaverse.
                            </p>
                            <Link
                                href={route('register')}
                                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-lg font-semibold text-purple-600 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300"
                            >
                                🎉 Create Your Account
                            </Link>
                        </div>
                    )}
                </main>

                <footer className="mt-16 text-center text-sm text-gray-600 dark:text-gray-400">
                    <p className="mb-2">
                        Built with ❤️ using Laravel, React, and modern web technologies
                    </p>
                    <p>
                        Powered by{" "}
                        <a 
                            href="https://app.build" 
                            target="_blank" 
                            className="font-medium text-blue-600 hover:underline dark:text-blue-400"
                        >
                            app.build
                        </a>
                    </p>
                </footer>
            </div>
        </>
    );
}