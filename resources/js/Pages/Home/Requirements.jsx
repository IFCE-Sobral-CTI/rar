import Header from "@/Components/Public/Header";
import Panel from "@/Components/Public/Panel";
import HomeLayout from "@/Layouts/HomeLayout";
import { Link } from "@inertiajs/react";
import React from "react";

export default function Requirements({ requirement }) {
    console.log(requirement)
    return (
        <HomeLayout>
            <div className="flex flex-col gap-2 md:gap-4 my-2">
                <Panel className={'flex flex-wrap justify-between gap-2'}>
                    <Header
                        title="Requerimento de Acesso ao Restaurante Acadêmico"
                        subtitle="Formulário de solicitação do cartão de acesso ao Restaurante Acadêmico do IFCE - Campus Sobral."
                    />
                </Panel>
                <Panel className="flex flex-wrap justify-between gap-2">
                    <h2 className="text-xl font-semibold text-center text-green">Requerimento enviado com sucesso!</h2>
                </Panel>
                <Panel className="flex flex-wrap justify-between gap-2">
                    <div className="flex flex-col gap-2 flex-1">
                        <h1 className="p-2 text-lg font-bold text-center">Dados que serão impressos na cartão usado no Restaurante Acadêmico</h1>
                        <div className="px-2">
                            <p className="font-light border-b">Nome</p>
                            <p className="font-bold">{requirement.student?.name}</p>
                        </div>
                        <div className="px-2">
                            <p className="font-light border-b">C.P.F.</p>
                            <p className="font-bold">{requirement.student?.cpf}</p>
                        </div>
                        <div className="px-2">
                            <p className="font-light border-b">R.G.</p>
                            <p className="font-bold">{requirement.student?.rg}</p>
                        </div>
                        <div className="px-2">
                            <p className="font-light border-b">Matricula</p>
                            <p className="font-bold">{requirement.enrollment?.number}</p>
                        </div>
                        <div className="px-2">
                            <p className="font-light border-b">Curso</p>
                            <p className="font-bold">{requirement.enrollment?.course?.name}</p>
                        </div>
                        <div className="px-2">
                            <p className="font-light border-b">Dias de aulas</p>
                            <div className="flex flex-col gap-2 md:flex-md md:justify-between">
                                {requirement?.weekdays?.map((item, i) => <span className='flex-1 font-bold' key={i}>{item.name}</span>)}
                            </div>
                        </div>
                        <div className="px-2">
                            <p className="font-light border-b">E-mails</p>
                            <p className="font-bold"><span className="font-light">Pessoal: </span>{requirement.student?.personal_email}</p>
                            <p className="font-bold"><span className="font-light">Acadêmico: </span>{requirement.student?.academic_email}</p>
                        </div>
                    </div>
                </Panel>
                <Panel className="flex flex-wrap justify-between gap-2">
                    <p className="text-center">Você receberá um e-mail de confirmação da sua solicitação.</p>
                    <p className="text-center">Aguarde que estamos confeccionando seu cartão de acesso ao restaurante acadêmico e logo estará pronto para retirada na recepção geral do <em>campus</em>.</p>
                </Panel>
                <Panel className="flex flex-wrap justify-between gap-2">
                    <Link href={route('home')} className="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-500 border border-transparent rounded-md active:bg-gray-700 hover:bg-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-4 h-4" viewBox="0 0 16 16">
                            <path fillRule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Voltar
                    </Link>
                </Panel>
            </div>
        </HomeLayout>
    )
}
