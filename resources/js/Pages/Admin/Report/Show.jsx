import React from "react";
import { Head, Link } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Button from "@/Components/Form/Button";
import DeleteModal from "@/Components/Dashboard/DeleteModal";
import ShowField from "@/Components/Dashboard/ShowField";
import Pagination from "@/Components/Dashboard/Pagination";

function Show({ report, dispatches, can }) {
    console.log(report);
    const table = dispatches.dispatches.data.map((item, index) => {
        return (
            <tr key={index} className={"border-t transition hover:bg-neutral-100 " + (index % 2 == 0? 'bg-neutral-50': '')}>
                <td className="px-1 py-3 font-light">
                    <Link href={can.dispatch_view && route('requirements.dispatches.show', {dispatch: item.id, requirement: item.requirement.id})}>
                        {item.requirement.requirement_type.description}
                    </Link>
                </td>
                <td className="px-1 py-3 font-light">
                    <Link href={can.dispatch_view && route('requirements.dispatches.show', {dispatch: item.id, requirement: item.requirement.id})}>
                        {item.requirement.enrollment.number}
                    </Link>
                </td>
                <td className="px-1 py-3 font-light">
                    <Link href={can.dispatch_view && route('requirements.dispatches.show', {dispatch: item.id, requirement: item.requirement.id})}>
                        {item.requirement.enrollment.student.name}
                    </Link>
                </td>
                <td className="flex justify-end py-3 pr-2 text-neutral-400">
                    <Link href={can.dispatch_view && route('requirements.dispatches.show', {dispatch: item.id, requirement: item.requirement.id})}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                            <path fillRule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </Link>
                </td>
            </tr>
        );
    });

    return (
        <>
            <Head title="Detalhes do relatório" />
            <AuthenticatedLayout
                titleChildren={'Detalhes do relatório'}
                breadcrumbs={[
                    { label: 'Relatórios', url: route('reports.index') },
                    { label: report.id, url: route('reports.show', report.id)}
                ]}
            >
                <Panel className={'flex gap-4'}>
                    <ShowField label={'Criado em'} value={report.created_at} />
                    <ShowField label={'Criado por'} value={report.user.name} />
                </Panel>

                <Panel>
                    <table className="w-full table-auto text-neutral-600">
                        <thead>
                            <tr className="border-b">
                                <th className="px-1 pt-3 font-semibold text-left w-2/12">Tipo</th>
                                <th className="px-1 pt-3 font-semibold text-left w-2/12">Matricula</th>
                                <th className="px-1 pt-3 font-semibold text-left w-6/12">Discente</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {table}
                        </tbody>
                    </table>
                    <Pagination data={dispatches.dispatches} count={dispatches.count} />
                </Panel>
                <Panel className={'flex flex-wrap items-center justify-center gap-1 md:gap-4'}>
                    <Button href={route('reports.index')} className={'gap-2'}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                            <path fillRule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        <span>Voltar</span>
                    </Button>
                    {can.delete && <DeleteModal url={route('reports.destroy', report.id)} />}
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Show;

