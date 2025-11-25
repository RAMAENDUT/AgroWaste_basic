import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link } from '@inertiajs/react';

export default function Landing({ auth }) {
    return (
        <GuestLayout>
            <Head title="Platform Edukasi Petani" />
            
            {/* Navbar */}
            <nav className="sticky top-0 z-50 backdrop-blur-md bg-white/80 border-b border-gray-200 shadow-sm">
                <div className="max-w-7xl mx-auto px-8 h-16 flex items-center justify-between">
                    <Link href="/" className="flex items-center gap-2 font-bold text-green-700 text-lg">
                        <span className="text-2xl">🌱</span>
                        <span>AgroWaste Academy</span>
                    </Link>
                    <div className="flex items-center gap-4">
                        {auth.user ? (
                            <Link href={route('home')} className="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold shadow-md">
                                Dashboard
                            </Link>
                        ) : (
                            <>
                                <Link href={route('login')} className="text-gray-700 hover:text-green-600 font-medium text-sm">
                                    Masuk
                                </Link>
                                <Link href={route('register')} className="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold shadow-md">
                                    Daftar Gratis
                                </Link>
                            </>
                        )}
                    </div>
                </div>
            </nav>

            {/* Hero Section */}
            <section className="relative bg-gradient-to-r from-green-700 via-green-600 to-orange-600 text-white px-8 py-20">
                <div className="max-w-6xl mx-auto">
                    <div className="text-center mb-12">
                        <h1 className="text-5xl md:text-6xl font-bold mb-4">
                            Platform Edukasi <br />Pengelolaan Limbah Pertanian
                        </h1>
                        <p className="text-lg text-green-50 max-w-2xl mx-auto">
                            Ubah limbah pertanian Anda menjadi produk bernilai ekonomis tinggi. Belajar dari para ahli dengan metode praktis dan mudah dipahami.
                        </p>
                    </div>
                    <div className="flex items-center justify-center gap-4 mb-12">
                        {auth.user ? (
                            <Link href={route('home')} className="px-8 py-3 bg-yellow-500 hover:bg-yellow-400 text-neutral-900 rounded-lg text-base font-bold shadow-lg">
                                Lanjutkan Belajar
                            </Link>
                        ) : (
                            <>
                                <Link href={route('register')} className="px-8 py-3 bg-yellow-500 hover:bg-yellow-400 text-neutral-900 rounded-lg text-base font-bold shadow-lg">
                                    Mulai Belajar Gratis
                                </Link>
                                <a href="#features" className="px-8 py-3 bg-white/20 hover:bg-white/30 backdrop-blur text-white rounded-lg text-base font-semibold border border-white/30">
                                    Pelajari Lebih Lanjut
                                </a>
                            </>
                        )}
                    </div>
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
                        <div className="bg-white/10 backdrop-blur rounded-xl p-6 border border-white/20 text-center">
                            <div className="text-4xl mb-3">📚</div>
                            <p className="text-3xl font-bold mb-1">15+</p>
                            <p className="text-sm text-green-100">Modul Pembelajaran</p>
                        </div>
                        <div className="bg-white/10 backdrop-blur rounded-xl p-6 border border-white/20 text-center">
                            <div className="text-4xl mb-3">🎓</div>
                            <p className="text-3xl font-bold mb-1">500+</p>
                            <p className="text-sm text-green-100">Petani Bergabung</p>
                        </div>
                        <div className="bg-white/10 backdrop-blur rounded-xl p-6 border border-white/20 text-center">
                            <div className="text-4xl mb-3">🧑‍🌾</div>
                            <p className="text-3xl font-bold mb-1">98%</p>
                            <p className="text-sm text-green-100">Kepuasan Pengguna</p>
                        </div>
                    </div>
                </div>
            </section>

            {/* Metrics Bar */}
            <section className="bg-gradient-to-r from-green-50 via-amber-50/40 to-green-50 py-10">
                <div className="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 text-center px-8">
                    <div>
                        <p className="text-4xl font-bold text-green-900">3+</p>
                        <p className="text-sm font-medium text-gray-700 mt-1">Modul Tersedia</p>
                    </div>
                    <div>
                        <p className="text-4xl font-bold text-green-900">9+</p>
                        <p className="text-sm font-medium text-gray-700 mt-1">Video Tutorial</p>
                    </div>
                    <div>
                        <p className="text-4xl font-bold text-green-900">100+</p>
                        <p className="text-sm font-medium text-gray-700 mt-1">Petani Bergabung</p>
                    </div>
                    <div>
                        <p className="text-4xl font-bold text-green-900">95%</p>
                        <p className="text-sm font-medium text-gray-700 mt-1">Kepuasan Pengguna</p>
                    </div>
                </div>
            </section>

            {/* Features Section */}
            <section id="features" className="px-8 py-20 bg-white">
                <div className="max-w-6xl mx-auto">
                    <div className="text-center mb-12">
                        <h2 className="text-4xl font-bold text-gray-900 mb-3">Fitur Unggulan Platform</h2>
                        <p className="text-gray-600 max-w-2xl mx-auto">Platform pembelajaran komprehensif yang dirancang khusus untuk petani Indonesia</p>
                    </div>
                    <div className="grid md:grid-cols-4 gap-6">
                        <div className="bg-green-100 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                            <div className="text-4xl mb-4">📚</div>
                            <h3 className="font-bold text-lg mb-2 text-gray-900">Modul Terstruktur</h3>
                            <p className="text-sm text-gray-600 leading-relaxed">Materi pembelajaran terorganisir dengan baik dari dasar hingga mahir</p>
                        </div>
                        <div className="bg-green-100 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                            <div className="text-4xl mb-4">📊</div>
                            <h3 className="font-bold text-lg mb-2 text-gray-900">Tracking Progress</h3>
                            <p className="text-sm text-gray-600 leading-relaxed">Pantau perkembangan belajar Anda dengan dashboard yang informatif</p>
                        </div>
                        <div className="bg-green-100 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                            <div className="text-4xl mb-4">✅</div>
                            <h3 className="font-bold text-lg mb-2 text-gray-900">Kuis Interaktif</h3>
                            <p className="text-sm text-gray-600 leading-relaxed">Uji pemahaman dengan kuis dan dapatkan feedback langsung</p>
                        </div>
                        <div className="bg-green-100 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                            <div className="text-4xl mb-4">🎯</div>
                            <h3 className="font-bold text-lg mb-2 text-gray-900">Praktis & Aplikatif</h3>
                            <p className="text-sm text-gray-600 leading-relaxed">Materi yang langsung bisa diterapkan di lahan pertanian Anda</p>
                        </div>
                    </div>
                </div>
            </section>

            {/* About Section */}
            <section className="px-8 py-20 bg-gradient-to-b from-amber-50 to-white">
                <div className="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 className="text-4xl font-bold mb-6 text-gray-900">Mengapa AgroWaste Academy?</h2>
                        <ul className="space-y-4 mb-6">
                            <li className="flex items-start gap-3">
                                <span className="text-green-600 text-xl mt-1">✓</span>
                                <div>
                                    <p className="font-semibold text-gray-900">Pembelajaran Fleksibel</p>
                                    <p className="text-sm text-gray-600">Belajar kapan saja, di mana saja sesuai waktu Anda</p>
                                </div>
                            </li>
                            <li className="flex items-start gap-3">
                                <span className="text-green-600 text-xl mt-1">✓</span>
                                <div>
                                    <p className="font-semibold text-gray-900">Gratis Selamanya</p>
                                    <p className="text-sm text-gray-600">Akses semua materi pembelajaran tanpa biaya</p>
                                </div>
                            </li>
                            <li className="flex items-start gap-3">
                                <span className="text-green-600 text-xl mt-1">✓</span>
                                <div>
                                    <p className="font-semibold text-gray-900">Praktis & Mudah Dipahami</p>
                                    <p className="text-sm text-gray-600">Materi disajikan dengan bahasa sederhana dan contoh nyata</p>
                                </div>
                            </li>
                        </ul>
                        <div className="bg-green-600 text-white rounded-xl p-6">
                            <p className="text-3xl font-bold mb-2">1000+</p>
                            <p className="text-sm text-green-100">Petani telah merasakan dampak positif pengelolaan limbah pertanian</p>
                        </div>
                    </div>
                    <div className="bg-gradient-to-br from-green-400 to-blue-500 rounded-2xl h-96 flex items-center justify-center shadow-xl">
                        <span className="text-9xl opacity-20">🌱</span>
                    </div>
                </div>
            </section>

            {/* Contact Section */}
            <section className="px-8 py-16 bg-white">
                <div className="max-w-6xl mx-auto">
                    <div className="text-center mb-10">
                        <h2 className="text-3xl font-bold text-gray-900 mb-2">Hubungi Kami</h2>
                        <p className="text-gray-600">Ada pertanyaan? Kami siap membantu Anda</p>
                    </div>
                    <div className="grid md:grid-cols-3 gap-6">
                        <div className="bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm hover:shadow-md transition">
                            <div className="text-4xl mb-3">✉️</div>
                            <h3 className="font-bold mb-2 text-gray-900">Email</h3>
                            <p className="text-sm text-gray-600">info@agrowaste.com</p>
                        </div>
                        <div className="bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm hover:shadow-md transition">
                            <div className="text-4xl mb-3">📞</div>
                            <h3 className="font-bold mb-2 text-gray-900">Telepon</h3>
                            <p className="text-sm text-gray-600">+62 812-3456-7890</p>
                        </div>
                        <div className="bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm hover:shadow-md transition">
                            <div className="text-4xl mb-3">📷</div>
                            <h3 className="font-bold mb-2 text-gray-900">Instagram</h3>
                            <p className="text-sm text-gray-600">@agrowaste.academy</p>
                        </div>
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className="py-20 bg-gradient-to-r from-green-700 to-orange-600 text-white text-center">
                <div className="max-w-4xl mx-auto px-8">
                    <h2 className="text-4xl font-bold mb-4">Siap Meningkatkan Nilai Pertanian Anda?</h2>
                    <p className="text-lg text-green-50 mb-8">Bergabunglah dengan ratusan petani yang telah merasakan manfaat pengelolaan limbah pertanian</p>
                    {auth.user ? (
                        <Link href={route('home')} className="inline-block px-8 py-3 bg-white text-green-700 rounded-lg text-base font-bold shadow-lg hover:bg-green-50">
                            Lanjutkan Belajar
                        </Link>
                    ) : (
                        <Link href={route('register')} className="inline-block px-8 py-3 bg-white text-green-700 rounded-lg text-base font-bold shadow-lg hover:bg-green-50">
                            Mulai Sekarang Gratis
                        </Link>
                    )}
                </div>
            </section>

            {/* Footer */}
            <footer className="bg-[#0d1218] text-gray-300 px-8 py-12">
                <div className="max-w-6xl mx-auto grid md:grid-cols-4 gap-8">
                    <div>
                        <div className="flex items-center gap-2 mb-4">
                            <span className="text-2xl">🌱</span>
                            <span className="font-bold text-white">AgroWaste Academy</span>
                        </div>
                        <p className="text-sm text-gray-400 leading-relaxed">Platform edukasi untuk petani Indonesia dalam mengelola limbah pertanian</p>
                    </div>
                    <div>
                        <h3 className="font-bold text-white mb-3">Tentang</h3>
                        <ul className="space-y-2 text-sm">
                            <li><a href="#" className="hover:text-green-500">Tentang Kami</a></li>
                            <li><a href="#" className="hover:text-green-500">Tim</a></li>
                            <li><a href="#" className="hover:text-green-500">Karir</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 className="font-bold text-white mb-3">Pembelajaran</h3>
                        <ul className="space-y-2 text-sm">
                            <li><a href="#" className="hover:text-green-500">Modul</a></li>
                            <li><a href="#" className="hover:text-green-500">Video</a></li>
                            <li><a href="#" className="hover:text-green-500">Kuis</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 className="font-bold text-white mb-3">Kontak</h3>
                        <ul className="space-y-2 text-sm">
                            <li><a href="#" className="hover:text-green-500">Hubungi Kami</a></li>
                            <li><a href="#" className="hover:text-green-500">FAQ</a></li>
                            <li><a href="#" className="hover:text-green-500">Bantuan</a></li>
                        </ul>
                    </div>
                </div>
                <div className="max-w-6xl mx-auto mt-8 pt-8 border-t border-gray-800 text-center text-sm text-gray-500">
                    <p>&copy; {new Date().getFullYear()} AgroWaste Academy. Semua hak dilindungi.</p>
                </div>
            </footer>
        </GuestLayout>
    );
}
