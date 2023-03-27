import React, { useEffect, useRef, useState } from "react";

function Select({
    children,
    name,
    value,
    className,
    isFocused,
    handleChange,
    required,
    processing
}) {
    const select = useRef();

    useEffect(() => {
        if (isFocused) {
            select.current.focus();
        }
    }, []);

    return (
        <>
            <select
                name={name}
                id={name}
                value={value?? ''}
                className={
                    `w-full border-neutral-400 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 rounded-lg shadow-sm ` +
                    className
                }
                ref={select}
                onChange={(e) => handleChange(e)}
                required={required}
                disabled={processing}
            >
                {children}
            </select>
        </>
    )
}

export default Select;
