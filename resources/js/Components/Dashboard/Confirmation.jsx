import {
    Modal,
    initTE,
} from "tw-elements";

import { useForm } from "@inertiajs/react";
import { useEffect } from "react";

export default function Confirmation({ url, message }) {
    const { post, processing } = useForm();

    useEffect(() => {
        initTE({ Modal });
    });

    const submit = (e) => {
        e.preventDefault();
        post(url, {
            preserveScroll: true
        });
    }

    return (
        <>
            <button
                type="button"
                data-te-toggle="modal"
                data-te-target="#confirmation-modal"
                className="inline-flex items-center gap-2 px-4 py-2 text-sm tracking-widest text-white transition duration-150 ease-in-out bg-sky-500 border border-transparent rounded-md active:bg-sky-700 hover:bg-sky-600"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="h-5 w-5" viewBox="0 0 16 16">
                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                    <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                </svg>
                <span>Enviar para impressão</span>
            </button>
            <div
                data-te-modal-init
                data-te-backdrop="static"
                data-te-keyboard="false"
                className="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
                id="confirmation-modal"
                tabIndex="-1"
                aria-labelledby="confirmation-modal-title"
                aria-modal="true"
                role="dialog"
            >
                <div
                    data-te-modal-dialog-ref
                    className="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]"
                >
                    <div
                        className="pointer-events-auto w-full md:w-3/6 lg:w-2/6 md:m-auto relative flex flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none"
                    >
                    <div
                        className="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4"
                    >
                        <h5
                            className="text-xl font-medium leading-normal text-neutral-800"
                            id="confirmation-modal-label"
                        >
                            Confirmação
                        </h5>
                        <button
                            type="button"
                            className="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                            data-te-modal-dismiss
                            aria-label="Close"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                strokeWidth="1.5"
                                stroke="currentColor"
                                className="h-6 w-6">
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                    <div className="relative p-4">
                        <p>{message?? 'Confirmar a operação?'}</p>
                    </div>
                    <div
                        className="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4"
                    >
                        <button
                            type="button"
                            className="flex items-center px-6 py-2.5 bg-gray-600 text-white font-light leading-tight rounded shadow-md hover:bg-gray-700 hover:shadow-lg focus:bg-gray-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-800 active:shadow-lg transition duration-150 ease-in-out"
                            data-te-modal-dismiss
                            data-te-ripple-color="light"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5 mr-3" role="img" aria-hidden="true" viewBox="0 0 16 16">
                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                            </svg>
                            <span>Não</span>
                        </button>
                        <form onSubmit={submit}>
                            <button
                                type="submit"
                                className="flex items-center px-6 py-2.5 bg-green text-white font-light leading-tight rounded shadow-md hover:bg-green-dark hover:shadow-lg focus:bg-green-dark focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-dark active:shadow-lg transition duration-150 ease-in-out ml-1"
                                data-te-modal-dismiss
                                data-te-ripple-color="light"
                                disabled={processing}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5 mr-3" role="img" aria-hidden="true" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                </svg>
                                <span>Sim</span>
                            </button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </>
    )
}
