import { Head, Link, useForm } from '@inertiajs/react';

export default function GuestLayout({ children, title = 'AgroWaste Academy' }) {
    return (
        <>
            <Head title={title} />
            <main>
                {children}
            </main>
        </>
    );
}
