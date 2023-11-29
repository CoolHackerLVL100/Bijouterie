import React, {Component} from "react"

class Reg extends Component {
    constructor(props){
        super(props)
        this.state = {
            error: 'ㅤ'
        }

        this.handleSubmit =this.handleSubmit.bind(this)
    }

    handleChange(event){
        
    }

    handleSubmit(event){
        fetch("http://localhost/Bijouterie/backend/api/user/reg/", {
            method: "POST",
            body: new FormData(event.target)
        })
        .then(res => res.json())
        .then(
            (result) => {
                
                if (result.status == 'Created'){
                    window.location = 'http://localhost:3000/auth'
                }
                else {
                    this.setState({
                        error: result.message
                    })         
                    console.log(this.state)
                }
            },
            (error) => {
                this.setState({
                    error
                })
            }
        )
     
        event.preventDefault()
    }

    render(){
        return (
            <div className="auth_form">
                <form onSubmit={this.handleSubmit} onChange={this.handleChange}>
                    <div className="field PlayfairDisplay">
                        <label>
                            Email
                            <input type="email" name="email" />
                        </label>                        
                    </div>
                    <div className="field PlayfairDisplay">
                        <label>
                            Логин
                            <input type="text" name="login" />
                        </label>                        
                    </div>
                    <div className="field PlayfairDisplay">
                        <label>
                            Пароль
                            <input type="password" name="password" />
                        </label>                        
                    </div>
                    <div className="field PlayfairDisplay">
                        <label>
                            Подтверждение пароля
                            <input type="password" name="password_confirm" />
                        </label>                        
                    </div>
                    
                    <p className="error_message PlayfairDisplay">
                        {this.state.error}
                    </p>

                    <button type="submit" className="PlayfairDisplay">Зарегистрироваться</button>

                    <a href='../auth' className="PlayfairDisplay">Уже есть аккаунт?</a>                       
                </form>  
            </div>
        )
    }
}

export default Reg

