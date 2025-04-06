import React from 'react'

function Signup() {
    return(
        <div className='d flex w-100 vh-100 bg-primary justify-content-center align items-center'>
            <h2>Signup</h2>
            <form>
                <div className="mb-3">
                    <label htmlFor="name"><strong>Name</strong></label>
                    <input type="text" placeholder="Enter Name" name="name" 
                    className='form-control rounded-0' />
                </div>
                <div className="mb-3">
                    <label htmlFor="email"><strong>Email</strong></label>
                    <input type="text" placeholder="Enter Email" name="email" 
                    className='form-control rounded-0' />
                </div>
                <div className="mb-3">
                    <label htmlFor="password"><strong>Password</strong></label>
                    <input type="text" placeholder="Enter Password" name="password" 
                    className='form-control rounded-0' />
                </div>
                <button type='submit' className='btn btn-success w-100 rounded-0'>Sign Up</button>
                <p>You agree to our terms and policies</p>
                <a to="/" className='btn btn default border w-1oo bg-light rounded-0 text-decoration-none'></a>

            </form>
        </div>
    )
}

export default Signup