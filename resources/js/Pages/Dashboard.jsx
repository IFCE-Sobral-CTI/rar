import React from 'react';
import 'tw-elements';
import Panel from '@/Components/Dashboard/Panel';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Dashboard({breadcrumbs, children}) {
    return (
        <>
            <AuthenticatedLayout breadcrumbs={[{label: 'Dashboard', url: route('admin')}]}>
                <Panel className="">
                    <div className="flex justify-between flex-wrap gap-4">
                        <div className="flex flex-col flex-1 items-center justify-center bg-lime-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase">Renovação</h3>
                            <p className="font-extrabold text-4xl">523</p>
                        </div>
                        <div className="flex flex-col flex-1 items-center justify-center bg-emerald-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase">Primeira via</h3>
                            <p className="font-extrabold text-4xl">523</p>
                        </div>
                        <div className="flex flex-col flex-1 items-center justify-center bg-cyan-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase">Segunda via</h3>
                            <p className="font-extrabold text-4xl">523</p>
                        </div>
                        <div className="flex flex-col flex-1 items-center justify-center bg-blue-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase">Requerimentos</h3>
                            <p className="font-extrabold text-4xl">523</p>
                        </div>
                        <div className="flex flex-col flex-1 items-center justify-center bg-violet-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase">Despachos</h3>
                            <p className="font-extrabold text-4xl">523</p>
                        </div>
                    </div>
                </Panel>
                <div className="grid grid-cols-2 grid-rows-2 gap-4">
                    <Panel>Renovações(Barras)</Panel>
                    <Panel>Segunda Via(Barras)</Panel>
                    <Panel>Primeira Via(Barras)</Panel>
                    <Panel>Impressões(Barras)</Panel>
                </div>
                <div className="grid grid-cols-6 grid-rows-2 gap-4">
                    <Panel className="col-span-2">Tipo de Curso(Circulo)</Panel>
                    <Panel className="col-span-2">Situação dos requerimentos(Circulo)</Panel>
                    <Panel className="col-span-2 row-span-2 flex flex-col gap-4">
                        <div className="flex flex-col flex-1 items-center justify-center bg-yellow-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase">Fila de Impressão</h3>
                            <p className="font-extrabold text-4xl">523</p>
                        </div>
                        <div className="flex flex-col flex-1 items-center justify-center bg-green-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase">Impressões</h3>
                            <p className="font-extrabold text-4xl">523</p>
                        </div>
                    </Panel>
                    <Panel className="col-span-4">Fila de Impressão</Panel>
                </div>
                <div className="text-right text-sm font-light">Dados referentes ao semestre: <strong className="font-bold text-neutral-600">2023.1</strong></div>
            </AuthenticatedLayout>
        </>
    )
}
