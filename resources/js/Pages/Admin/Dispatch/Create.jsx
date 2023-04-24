import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Create({ requirement }) {
    const { data, setData, post, processing, errors } = useForm({
        text: '',
        observation: '',
        status: '',
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('requirements.dispatches.store', requirement.id), {data});
    };

    return (
        <>
            <Head title="Novo despacho" />
            <AuthenticatedLayout
                titleChildren={'Cadastro de novo despacho'}
                breadcrumbs={[
                    { label: 'Requerimentos', url: route('requirements.index') },
                    { label: `${requirement.enrollment.number} - ${requirement.enrollment.student.name}`, url: route('requirements.show', requirement.id) },
                    { label: 'Despachos', url: route('requirements.dispatches.index', requirement.id) },
                    { label: 'Novo'}
                ]}
            >
                <Panel className={'flex gap-4'}>
                    <div className="">
                        <div className="font-light">Discente</div>
                        <div className="">{requirement.enrollment.student.name}</div>
                    </div>
                    <div className="">
                        <div className="font-light">Matricula</div>
                        <div className="">{requirement.enrollment.number}</div>
                    </div>
                    <div className="">
                        <div className="font-light">Curso</div>
                        <div className="">{requirement.enrollment.course.name}</div>
                    </div>
                </Panel>
                <Panel className={'flex-1'}>
                    <Form
                        data={data}
                        errors={errors}
                        processing={processing}
                        onHandleChange={onHandleChange}
                        handleSubmit={handleSubmit}
                        requirement={requirement}
                    />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Create;

