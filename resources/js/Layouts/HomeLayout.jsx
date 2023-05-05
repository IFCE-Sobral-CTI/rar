import React, { useEffect, useState } from 'react';
import { usePage, Head } from '@inertiajs/react';
import Navbar from '@/Components/Public/Navbar';
import Footer from '@/Components/Public/Footer';
import AlertContext from '@/Context/AlertContext';
import Alert from '@/Components/Dashboard/Alert';

export default function HomeLayout({ children }) {
    const { title, flash } = usePage().props;
    const [alert, setAlert] = useState(false);
    const [message, setMessage] = useState();
    const [type, setType] = useState();

    useEffect(() => {
        if (flash?.flash) {
            setAlert(true);
            setMessage(flash.flash.message);
            setType(flash.flash.status);
        }
    }, [flash]);

    return (
        <>
            <AlertContext.Provider value={{ alert, setAlert, type, setType, message, setMessage }}>
                <Alert />
            </AlertContext.Provider>
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
