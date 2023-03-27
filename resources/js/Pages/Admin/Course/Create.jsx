import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Create() {
    const { data, setData, post, processing, errors } = useForm({
        cod: '',
        name: '',
        status: '',
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('courses.store'), {data});
    };

    return (
        <>
            <Head title="Novo curso" />
            <AuthenticatedLayout titleChildren={'Cadastro de novo curso'} breadcrumbs={[{ label: 'Curso', url: route('courses.index') }, { label: 'Novo', url: route('courses.create') }]}>
                <Panel className={'flex-1'}>
                    <Form data={data} errors={errors} processing={processing} onHandleChange={onHandleChange} handleSubmit={handleSubmit} />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Create;

