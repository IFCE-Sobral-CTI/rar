import React from 'react';
import { usePage, Head } from '@inertiajs/react';
import Navbar from '@/Components/Public/Navbar';
import Footer from '@/Components/Public/Footer';

export default function HomeLayout({ children }) {
    const { title } = usePage().props;
    return (
        <>
            <Head title={title} />
            <div className="flex flex-col items-start w-screen min-h-screen bg-neutral-100 text-neutral-700">
                <Navbar />
                <main className="flex-1 flex flex-col w-full md:p-2">
                    {children}
                </main>
                <Footer />
            </div>
        </>
    );
}
