import React, { useEffect } from "react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-react";
import CustomersLayout from "@/Layouts/CustomersLayout";

export default function Login() {
  const { flash } = usePage().props;

  const { data, setData, post, processing, errors, reset } = useForm({
    email: "",
    password: "",
  });

  useEffect(() => {
    return () => {
      reset("password");
    };
  }, []);

  const onHandleChange = (event) => {
    setData(
      event.target.name,
      event.target.type === "checkbox"
        ? event.target.checked
        : event.target.value
    );
  };

  const submit = (e) => {
    e.preventDefault();
    post(route("postLogin"));
  };

  return (
    <CustomersLayout>
      <Head title="Log in" />
      <div className="">
        <div className="mx-auto w-11/12 md:w-7/12 lg:w-5/12 xl:w-3/12 border p-10 mt-20 md:mt-52 rounded-xl shadow-2xl bg-[#ede0d4]">
          {flash.message && (
            <div className="p-2 bg-white rounded-lg text-white">
              {flash.message}
            </div>
          )}
          <h1 className="text-2xl text-center mb-10">Login</h1>
          <div>
            <InputError message={errors.wrong} className="mb-2" />
          </div>
          <form onSubmit={submit}>
            <div>
              <InputLabel forInput="email" value="Email" />

              <TextInput
                type="text"
                name="email"
                value={data.email}
                className="mt-1 block w-full"
                autoComplete="username"
                isFocused={true}
                handleChange={onHandleChange}
              />

              <InputError message={errors.email} className="mt-2" />
            </div>

            <div className="mt-4">
              <InputLabel forInput="password" value="Password" />

              <TextInput
                type="password"
                name="password"
                value={data.password}
                className="mt-1 block w-full"
                autoComplete="current-password"
                handleChange={onHandleChange}
              />

              <InputError message={errors.password} className="mt-2" />
            </div>

            <div className="flex items-center justify-between mt-4">
              <Link href="/register" className="hover:underline">
                Ga Punya Akun?
              </Link>
              <PrimaryButton className="ml-4" processing={processing}>
                Log in
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </CustomersLayout>
  );
}
