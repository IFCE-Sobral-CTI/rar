import React from "react";
import Input from "@/Components/Form/Input";
import InputError from "@/Components/InputError";
import Button from "@/Components/Form/Button";

export default function Form({data, errors, handleSubmit, onHandleChange, processing }) {
    return (
        <form onSubmit={handleSubmit} autoComplete="off">
            <div className="mb-4">
                <label htmlFor="name" className="font-light">Nome</label>
                <Input initialValue={data.name} name={'name'} handleChange={onHandleChange} required={true} placeholder="Nome completo" className={'w-full'} isFocused={true} />
                <InputError message={errors.name} />
            </div>
            <div className="mb-4">
                <label htmlFor="cpf" className="font-light">C.P.F.</label>
                <Input mask={'000.000.000-00'} initialValue={data.cpf} name={'cpf'} handleChange={onHandleChange} required={true} placeholder="Cadastro de Pessoal Física" className={'w-full'} />
                <InputError message={errors.cpf} />
            </div>
            <div className="mb-4">
                <label htmlFor="rg" className="font-light">R.G.</label>
                <Input type="number" initialValue={data.rg} name={'rg'} handleChange={onHandleChange} required={true} placeholder="Registro Geral (Identidade)" className={'w-full'} />
                <InputError message={errors.rg} />
            </div>
            <div className="mb-4">
                <label htmlFor="birth" className="font-light">Data de nascimento</label>
                <Input type="date" initialValue={data.birth} name={'birth'} handleChange={onHandleChange} required={true} placeholder="Data de Nascimento"  className={'w-full'}/>
                <InputError message={errors.birth} />
            </div>
            <div className="mb-4">
                <label htmlFor="personal_email" className="font-light">E-mail pessoal</label>
                <Input type="email" initialValue={data.personal_email} name={'personal_email'} handleChange={onHandleChange} required={true} placeholder="E-mail secundário" className={'w-full'} />
                <InputError message={errors.personal_email} />
            </div>
            <div className="mb-4">
                <label htmlFor="institutional_email" className="font-light">E-mail acadêmico</label>
                <Input type="email" initialValue={data.institutional_email} name={'institutional_email'} handleChange={onHandleChange} required={true} placeholder="E-mail acadêmico" className={'w-full'} />
                <InputError message={errors.institutional_email} />
            </div>
            <div className="flex items-center justify-center gap-4 mt-6">
                <Button type={'submit'} processing={processing} color={'green'} className={"gap-2"}>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                        <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                    </svg>
                    <span>Enviar</span>
                </Button>
                <Button href={route('students.index')} className={'gap-2'}>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                        <path fillRule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                    </svg>
                    <span>Voltar</span>
                </Button>
            </div>
        </form>
    )
}

