import React from "react";
import Input from "@/Components/Form/Input";
import InputError from "@/Components/InputError";
import Button from "@/Components/Form/Button";
import Select from "@/Components/Form/Select";
import SelectOnly from "@/Components/Form/SelectOnly";

export default function Form({data, errors, handleSubmit, onHandleChange, processing, courses }) {
    return (
        <form onSubmit={handleSubmit} autoComplete="off">
            <div className="mb-4">
                <label htmlFor="status" className="font-light">Situação</label>
                <Select name={'status'} value={data.status} handleChange={onHandleChange} required={true} className={'w-full'}>
                    <option className="text-gray-500">Selecione uma opção</option>
                    <option value={1}>Ativo</option>
                    <option value={0}>Inativo</option>
                </Select>
                <InputError message={errors.status} />
            </div>
            <div className="mb-4">
                <label htmlFor="number" className="font-light">Matrícula</label>
                <Input mask={'0000000000000000'} initialValue={data.number} name={'number'} handleChange={onHandleChange} required={true} placeholder="Código do curso" className={'w-full'} isFocused={true} />
                <InputError message={errors.number} />
            </div>
            <SelectOnly value={data.course_id} data={courses} onChange={onHandleChange} error={errors.course_id} label={'Curso'} name={'course_id'} required />
            <div className="flex items-center justify-center gap-4 mt-6">
                <Button type={'submit'} processing={processing} color={'green'} className={"gap-2"}>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                        <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                    </svg>
                    <span>Enviar</span>
                </Button>
                <Button
                    href={data.id
                        ?route('students.enrollments.show', {student: data.student.id, enrollment: data.id})
                        :route('students.enrollments.index', { student: data.student.id })
                    }
                    className={'gap-2'}
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                        <path fillRule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                    </svg>
                    <span>Voltar</span>
                </Button>
            </div>
        </form>
    )
}

