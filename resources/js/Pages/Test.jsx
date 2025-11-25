export default function Test() {
    return (
        <div className="min-h-screen bg-gradient-to-r from-green-700 via-green-600 to-orange-600 flex items-center justify-center">
            <div className="bg-white rounded-3xl shadow-2xl p-12 text-center max-w-2xl">
                <h1 className="text-6xl font-bold text-green-600 mb-4">React Is Working! ✅</h1>
                <p className="text-2xl text-gray-700 mb-6">Inertia.js + React berhasil!</p>
                <div className="flex gap-4 justify-center">
                    <div className="bg-green-100 text-green-800 px-6 py-3 rounded-lg font-semibold">
                        ✨ Tailwind CSS
                    </div>
                    <div className="bg-orange-100 text-orange-800 px-6 py-3 rounded-lg font-semibold">
                        🚀 Vite HMR
                    </div>
                    <div className="bg-blue-100 text-blue-800 px-6 py-3 rounded-lg font-semibold">
                        ⚡ Laravel 11
                    </div>
                </div>
            </div>
        </div>
    );
}
