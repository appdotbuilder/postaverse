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
            <div className="flex min-h-screen flex-col items-center bg-gradient-to-br from-slate-900 via-purple-900 to-indigo-950 p-6 text-white lg:justify-center lg:p-8">
                <header className="mb-8 w-full max-w-4xl">
                    <nav className="flex items-center justify-between">
                        <div className="flex items-center gap-2">
                            <div className="h-8 w-8 rounded-full bg-gradient-to-r from-purple-500 to-blue-500"></div>
                            <span className="text-xl font-bold">🌌 Postaverse</span>
                        </div>
                        <div className="flex items-center gap-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="inline-flex items-center rounded-full bg-purple-600 px-6 py-2 text-sm font-medium text-white shadow-lg hover:bg-purple-700 transition-all duration-200"
                                >
                                    🚀 Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="inline-flex items-center rounded-full px-6 py-2 text-sm font-medium text-gray-300 hover:text-purple-400 transition-colors duration-200"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="inline-flex items-center rounded-full bg-purple-600 px-6 py-2 text-sm font-medium text-white shadow-lg hover:bg-purple-700 transition-all duration-200"
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
                        <h1 className="mb-6 text-5xl font-bold bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent lg:text-7xl">
                            🌟 Welcome to Postaverse
                        </h1>
                        <p className="mb-8 text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                            The cosmic social media platform where connections thrive in deep space. Share your world, discover stellar content, and build meaningful relationships across the universe.
                        </p>
                        {!auth.user && (
                            <div className="flex gap-4 justify-center">
                                <Link
                                    href={route('register')}
                                    className="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-purple-600 to-blue-600 px-8 py-4 text-lg font-semibold text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300"
                                >
                                    🚀 Join the Universe
                                </Link>
                                <Link
                                    href={route('login')}
                                    className="inline-flex items-center gap-2 rounded-full border-2 border-purple-500 px-8 py-4 text-lg font-semibold text-purple-300 hover:bg-purple-600 hover:text-white transition-all duration-300"
                                >
                                    ⭐ Sign In
                                </Link>
                            </div>
                        )}
                    </div>

                    {/* Features Grid */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                        <div className="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-purple-500/20 shadow-xl hover:shadow-purple-500/20 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div className="text-4xl mb-4">🌌</div>
                            <h3 className="text-xl font-bold mb-3 text-purple-300">Cosmic Feed</h3>
                            <p className="text-gray-300">
                                Navigate through space and discover content that resonates with your stellar interests. Our cosmic algorithm learns your preferences across galaxies.
                            </p>
                        </div>

                        <div className="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-blue-500/20 shadow-xl hover:shadow-blue-500/20 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div className="text-4xl mb-4">🌟</div>
                            <h3 className="text-xl font-bold mb-3 text-blue-300">Stellar Communities</h3>
                            <p className="text-gray-300">
                                Create and join cosmic groups based on your interstellar interests. From nebula photography to quantum coding - find your constellation.
                            </p>
                        </div>

                        <div className="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-cyan-500/20 shadow-xl hover:shadow-cyan-500/20 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div className="text-4xl mb-4">💫</div>
                            <h3 className="text-xl font-bold mb-3 text-cyan-300">Quantum Messaging</h3>
                            <p className="text-gray-300">
                                Communicate instantly across the cosmos with our advanced messaging system. Share stardust memories and have meaningful conversations.
                            </p>
                        </div>

                        <div className="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-purple-500/20 shadow-xl hover:shadow-purple-500/20 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div className="text-4xl mb-4">🎨</div>
                            <h3 className="text-xl font-bold mb-3 text-purple-300">Nebula Creation</h3>
                            <p className="text-gray-300">
                                Express your cosmic creativity with our powerful rich content editor. Create posts that shine brighter than supernovas.
                            </p>
                        </div>

                        <div className="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-blue-500/20 shadow-xl hover:shadow-blue-500/20 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div className="text-4xl mb-4">🛸</div>
                            <h3 className="text-xl font-bold mb-3 text-blue-300">Galactic Media</h3>
                            <p className="text-gray-300">
                                Share your cosmic adventures with seamless media uploads. Support for all earthly and extraterrestrial formats.
                            </p>
                        </div>

                        <div className="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-cyan-500/20 shadow-xl hover:shadow-cyan-500/20 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div className="text-4xl mb-4">🔒</div>
                            <h3 className="text-xl font-bold mb-3 text-cyan-300">Universal Privacy</h3>
                            <p className="text-gray-300">
                                Your cosmic privacy is sacred. Control who sees your stellar content with quantum-encrypted privacy settings.
                            </p>
                        </div>
                    </div>

                    {/* Stats Section */}
                    <div className="bg-gray-800/30 backdrop-blur-sm rounded-3xl p-12 border border-purple-500/20 shadow-2xl mb-16">
                        <h2 className="text-3xl font-bold text-center mb-8">Join the Cosmic Community</h2>
                        <div className="grid md:grid-cols-3 gap-8 text-center">
                            <div>
                                <div className="text-4xl font-bold text-purple-400 mb-2">1M+</div>
                                <div className="text-gray-300">Cosmic Travelers</div>
                            </div>
                            <div>
                                <div className="text-4xl font-bold text-blue-400 mb-2">50K+</div>
                                <div className="text-gray-300">Star Systems</div>
                            </div>
                            <div>
                                <div className="text-4xl font-bold text-cyan-400 mb-2">10M+</div>
                                <div className="text-gray-300">Stellar Posts</div>
                            </div>
                        </div>
                    </div>

                    {/* CTA Section */}
                    {!auth.user && (
                        <div className="text-center bg-gradient-to-r from-purple-900/80 via-blue-900/80 to-cyan-900/80 backdrop-blur-sm rounded-3xl p-12 border border-purple-500/30 text-white shadow-2xl">
                            <h2 className="text-3xl font-bold mb-4">Ready to Explore the Cosmos? 🌌</h2>
                            <p className="text-xl mb-8 opacity-90">
                                Join thousands of cosmic travelers who are already sharing, connecting, and discovering across the universe.
                            </p>
                            <Link
                                href={route('register')}
                                className="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-purple-600 to-blue-600 px-8 py-4 text-lg font-semibold text-white shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300"
                            >
                                🚀 Begin Your Journey
                            </Link>
                        </div>
                    )}
                </main>

                <footer className="mt-16 text-center text-sm text-gray-400">
                    <p className="mb-2">
                        Built with ❤️ in the cosmic void using Laravel, React, and quantum technologies
                    </p>
                    <p>
                        Powered by{" "}
                        <a 
                            href="https://app.build" 
                            target="_blank" 
                            className="font-medium text-purple-400 hover:underline"
                        >
                            app.build
                        </a>
                    </p>
                </footer>
            </div>
        </>
    );
}