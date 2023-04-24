import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Edit({ dispatch, requirement }) {
    const { data, setData, put, processing, errors } = useForm({
        text: dispatch.text,
        observation: dispatch.observation,
        status: dispatch.status,
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('requirements.dispatches.update', {dispatch: dispatch.id, requirement: requirement.id}), {data});
    };

    return (
        <>
            <Head title="Editar despacho" />
            <AuthenticatedLayout
                titleChildren={'Editar despacho'}
                breadcrumbs={[
                    { label: 'Requerimentos', url: route('requirements.index') },
                    { label: `${requirement.enrollment.number} - ${requirement.enrollment.student.name}`, url: route('requirements.show', requirement.id) },
                    { label: 'Despachos', url: route('requirements.dispatches.index', requirement.id) },
                    { label: dispatch.id, url: route('requirements.dispatches.show', { dispatch: dispatch.id, requirement: requirement.id }) },
                    { label: 'Editar'}
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
                <Panel>
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

export default Edit;

