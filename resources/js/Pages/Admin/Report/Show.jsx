import React from "react";
import { Head, Link } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Button from "@/Components/Form/Button";
import DeleteModal from "@/Components/Dashboard/DeleteModal";
import ShowField from "@/Components/Dashboard/ShowField";
import Pagination from "@/Components/Dashboard/Pagination";
import Confirmation from "@/Components/Dashboard/Confirmation";

function Show({ report, dispatches, can }) {
    const status = (status) => {
        let className = 'py-1 px-2 rounded-md text-sm text-white';
        if (status) {
            className += ' bg-green-500';
        } else {
            className += ' bg-yellow-500';
        }

        return (
            <span className={className}>{status == '1' ? 'Enviado' : 'Não enviado'}</span>
        )
    }

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
                    <ShowField label={'Enviado para reprografia'} value={status(report.printed)} />
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
                    {(can.update) &&
                        <Confirmation
                            url={route('reports.send', report.id)}
                            method={'get'}
                            values={{printed: true}}
                            message={'Após a confirmação um e-mail será enviado a reprografia que fará a impressão dos cartões e esse relatório constará como impresso. Você confirma o envio para a reprografia?'}
                            textButton={'Enviar para reprografia'}
                            iconButton={<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16" className="w-5 h-5">
                                <path fill="currentColor" d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576L6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76l7.494-7.493Z"/>
                            </svg>}
                        />
                    }
                    {(!!report.file) &&
                        <a
                            href={route('reports.view', { report: report.id })}
                            className='inline-flex gap-2 items-center px-4 py-2 border border-transparent tracking-widest text-sm rounded-lg text-white transition ease-in-out duration-150 focus:ring-2 bg-blue-500 hover:bg-blue-600 focus:ring-blue-300 '
                            target='_blank'
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16" className="h-5 w-5">
                                <path fill="currentColor" fillRule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173c.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38a.574.574 0 0 1-.238.241a.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181c.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084c0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592a1.14 1.14 0 0 1-.196.422a.8.8 0 0 1-.334.252a1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z"/>
                            </svg>
                            <span>Visualizar</span>
                        </a>
                    }
                    {can.delete && <DeleteModal url={route('reports.destroy', report.id)} />}
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Show;

