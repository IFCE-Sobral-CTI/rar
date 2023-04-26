import React, { useEffect, useState } from 'react';
import { useIMask } from 'react-imask';

export default function Input({
    type = 'text',
    name,
    className,
    autoComplete,
    required,
    isFocused,
    handleChange,
    mask = null,
    placeholder,
    processing,
    initialValue = null
}) {
    const [ opts, setOpts ] = useState({ mask: mask });
    const {
        ref,
        maskRef,
        value,
        setValue,
        unmaskedValue,
        setUnmaskedValue,
        typedValue,
        setTypedValue,
    } = useIMask(opts);

    useEffect(() => {
        if (initialValue)
            setValue(initialValue);
    }, []);

    return (
        <div className="flex flex-col items-start">
            <input
                value={mask? value: initialValue}
                type={type}
                name={name}
                className={
                    `w-full border-neutral-400 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 rounded-lg shadow-sm ` +
                    className
                }
                ref={ref}
                required={required}
                onChange={(e) => handleChange(e)}
                placeholder={placeholder}
                autoFocus={isFocused?? false}
                disabled={processing}
            />
        </div>
    );
}
