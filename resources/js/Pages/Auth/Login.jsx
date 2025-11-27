import InputError from '@/Components/InputError';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('login'), { onFinish: () => reset('password') });
    };

    return (
        <div className="min-h-screen flex bg-neutral-900 text-sm">
            <Head title="Login" />
            <div className="hidden md:flex flex-col justify-center items-center w-2/5 bg-gradient-to-br from-green-700 via-green-600 to-orange-600 text-white px-10 relative overflow-hidden">
                <div className="absolute inset-0 opacity-20 bg-[url('/images/hero-placeholder.jpg')] bg-cover bg-center" />
                <div className="relative z-10 max-w-xs text-center">
                    <div className="w-14 h-14 mx-auto mb-6 rounded-lg bg-white/15 backdrop-blur flex items-center justify-center text-2xl">🌱</div>
                    <h1 className="font-bold text-lg leading-relaxed">Selamat Datang Kembali di AgroWaste</h1>
                    <p className="mt-4 text-[11px] leading-relaxed text-green-50">Masuk untuk melanjutkan perjalanan belajar dan kelola limbah pertanian secara berkelanjutan.</p>
                </div>
            </div>
            <div className="flex-1 flex items-center justify-center bg-neutral-50">
                <div className="w-full max-w-md px-8 py-10">
                    <div className="mb-8">
                        <Link href={route('landing')} className="inline-flex items-center gap-1 text-xs text-gray-600 hover:text-green-600 mb-4">
                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali ke Beranda
                        </Link>
                        <div className="flex items-center gap-2 mb-2"><span className="w-8 h-8 flex items-center justify-center rounded-md bg-green-600 text-white text-lg">🌱</span><div><p className="font-semibold text-green-700">AgroWaste</p><p className="text-[10px] text-gray-500 -mt-1">Platform Edukasi Limbah</p></div></div>
                        <h2 className="text-base font-semibold mb-1">Masuk ke Akun</h2>
                        <p className="text-[11px] text-gray-600">Gunakan email dan password Anda</p>
                        {status && <div className="mt-2 text-[11px] font-medium text-green-600">{status}</div>}
                    </div>
                    <form onSubmit={submit} className="space-y-4">
                        <div>
                            <label htmlFor="email" className="block text-xs font-medium text-gray-700">Email</label>
                            <input id="email" type="email" name="email" value={data.email} onChange={e=>setData('email', e.target.value)} autoComplete="username" required className="mt-1 w-full rounded border border-gray-300 bg-white px-3 py-2 text-xs focus:border-green-500 focus:ring-green-500" />
                            <InputError message={errors.email} className="mt-1 text-[11px]" />
                        </div>
                        <div>
                            <label htmlFor="password" className="block text-xs font-medium text-gray-700">Password</label>
                            <input id="password" type="password" name="password" value={data.password} onChange={e=>setData('password', e.target.value)} autoComplete="current-password" required className="mt-1 w-full rounded border border-gray-300 bg-white px-3 py-2 text-xs focus:border-green-500 focus:ring-green-500" />
                            <InputError message={errors.password} className="mt-1 text-[11px]" />
                        </div>
                        <div className="flex items-center justify-between">
                            <label className="flex items-center gap-2 text-[11px] text-gray-600">
                                <input type="checkbox" name="remember" checked={data.remember} onChange={e=>setData('remember', e.target.checked)} className="rounded border-gray-300 text-green-600 focus:ring-green-500" /> Ingat saya
                            </label>
                            {canResetPassword && (
                                <Link href={route('password.request')} className="text-[11px] text-green-700 hover:underline">Lupa password?</Link>
                            )}
                        </div>
                        <button type="submit" disabled={processing} className="w-full bg-green-600 hover:bg-green-500 text-white rounded py-2 text-xs font-medium shadow disabled:opacity-60 disabled:cursor-not-allowed">{processing ? 'Memproses...' : 'Masuk →'}</button>
                        <p className="text-[11px] text-center text-gray-600">Belum punya akun? <Link href={route('register')} className="text-green-700 hover:underline">Daftar Sekarang</Link></p>
                    </form>
                </div>
            </div>
        </div>
    );
}
