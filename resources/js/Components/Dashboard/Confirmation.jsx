import {
    Modal,
    initTE,
} from "tw-elements";

import { useForm } from "@inertiajs/react";
import { useEffect } from "react";

export default function Confirmation({ url, message, textButton, iconButton, values, method }) {
    const { post, put, get, delete: destroy, processing } = useForm({...values});

    useEffect(() => {
        initTE({ Modal });
    });

    const submit = (e) => {
        e.preventDefault();
        switch(method) {
            case 'post':
                post(url, {
                    preserveScroll: true
                });
                break;
            case 'put':
                put(url, {
                    preserveScroll: true
                });
                break;
            case 'delete':
                destroy(url, {
                    preserveScroll: true
                });
                break;
            default:
                get(url);
        }
    }

    return (
        <>
            <button
                type="button"
                data-te-toggle="modal"
                data-te-target="#confirmation-modal"
                className="inline-flex items-center gap-2 px-4 py-2 text-sm tracking-widest text-white transition duration-150 ease-in-out bg-green-500 border border-transparent rounded-md active:bg-green-700 hover:bg-green-600"
            >
                {iconButton??
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16" className="h-5 w-5">
                    <g fill="currentColor">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25c.09-.656.54-1.134 1.342-1.134c.686 0 1.314.343 1.314 1.168c0 .635-.374.927-.965 1.371c-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486c.609-.463 1.244-.977 1.244-2.056c0-1.511-1.276-2.241-2.673-2.241c-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927c.609 0 1.028-.394 1.028-.927c0-.552-.42-.94-1.029-.94c-.584 0-1.009.388-1.009.94z"/>
                    </g>
                </svg>
                }
                <span>{textButton?? 'Confirmação'}</span>
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
