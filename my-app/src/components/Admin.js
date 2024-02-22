import React, {Component} from "react"
import '../css/Admin.css'
import Table from "./Table"
import Stats from "./Stats"
import getCookie from "./Cookies"

class Admin extends Component {   
    constructor(props){
        super(props)

        this.state = {
            catalog: null,
            point: null
        }

        this.defaultParams = {
            user: {
                min_registration_date: '',
                max_registration_date: '',
                min_personal_stock: '',
                max_personal_stock: '',
                firstname: '',
                lastname: '',
                emailname: '',
                gender: ''
            },
            product: {
                type: '',
                min_price: '',
                max_price: '',
                gender: '',
                size: '',
                stones: '',
                materials: ''
            }
        }
        this.handleClick = this.handleClick.bind(this)
    }

    handleClick(event, catalog, point) {
        this.setState({
            catalog: catalog,
            point: point
        })
        
    }

    makeBackup(event, table){
        event.preventDefault()

        fetch('http://localhost/Bijouterie/backend/api/backup/' + table + '/', {          
            method: 'GET',
            credentials: 'include',
            headers: {
                Authorization: getCookie('jwt')
            }
        })
        .then(res => res.json())
        .then(
            (result) => {
                const blob = new Blob([JSON.stringify(result.data)], {type: 'application/json'})
                const url = URL.createObjectURL(blob)
                const a = document.createElement('a')
                a.href = url

                const date = new Date()
                
                a.download = table + '_' + date.getFullYear() + '.' + date.getMonth() + '.' + date.getDate() + '-' + date.getHours() + '.' + date.getMinutes() + '.' + date.getSeconds() + '.json' 
                document.body.appendChild(a)
                a.click()

                document.body.removeChild(a)
                URL.revokeObjectURL(url)
            }, 
            (error) => {
                console.log(error)
            }
        )
    }

    restore(event, table){
        event.preventDefault()
        let formData = new FormData()
        formData.append(table, event.target.children[1].files[0])

        fetch('http://localhost/Bijouterie/backend/api/restore/' + table + '/', {          
            method: 'POST',
            credentials: 'include',
            headers: {
                Authorization: getCookie('jwt')
            },
            body: formData   
        })
    }

    renderContent(){
        switch(this.state.catalog){
            case 'tables': 
                switch (this.state.point){
                    case 'user':
                        return (
                            <Table table={this.state.point} params={{
                                min_registration_date: '',
                                max_registration_date: '',
                                min_personal_stock: '',
                                max_personal_stock: '',
                                firstname: '',
                                lastname: '',
                                emailname: '',
                                gender: ''
                            }}/>     
                        )      
                    case 'product':
                        return (
                            <Table table={this.state.point} params={{
                                type: '',
                                min_price: '0',
                                max_price: '100',
                                gender: '',
                                size: '',
                                stones: '',
                                materials: ''
                            }}/>  
                        )                  
                }
                break;

            case 'stats':
                return (
                    <Stats category={this.state.point} />
                )

            case 'report':
                switch (this.state.point){
                    case 'backup':
                        return (
                            <div className="container">
                                <div className="backup-section">
                                    <form onSubmit={event => this.restore(event, 'user')} encType="multipart/form-data">
                                        <button onClick={event => this.makeBackup(event, 'user')}>Пользователи</button>                            

                                            <input type="file"></input>
                                            <button type="submit">Восстановить</button>    
                                                                             
                                    </form>
                                    <form onSubmit={event => this.restore(event, 'product')} encType="multipart/form-data">
                                        <button onClick={event => this.makeBackup(event, 'product')}>Товары</button>                            

                                            <input type="file"></input>
                                            <button type="submit">Восстановить</button>    
                                         
                                    </form>
                                    <form onSubmit={event => this.restore(event, 'order')} encType="multipart/form-data">
                                        <button onClick={event => this.makeBackup(event, 'order')}>Заказы</button>                            

                                            <input type="file"></input>
                                            <button type="submit">Восстановить</button>    
                                                                                
                                    </form>
                                             
                                </div>
                            </div>
                        )
                }

        }
    }

    render(){
        return (
            <div>
                <aside className="admin-aside">
                    <details className="tables">
                        <summary className="PlayfairDisplay">Таблицы</summary>
                        <button className="point PlayfairDisplay" onClick={event => this.handleClick(event, 'tables', 'user')}>Пользователи</button>
                        <button className="point PlayfairDisplay" onClick={event => this.handleClick(event, 'tables', 'product')}>Товары</button>
                        <button className="point PlayfairDisplay" onClick={event => this.handleClick(event, 'tables', 'gallery')}>Галерея</button>
                        <button className="point PlayfairDisplay" onClick={event => this.handleClick(event, 'tables', 'gallery')}>Отзывы</button>
                        <button className="point PlayfairDisplay" onClick={event => this.handleClick(event, 'tables', 'order')}>Заказы</button>
                    </details>
                    <details className="statistics">
                        <summary className="PlayfairDisplay">Статистика</summary>
                        <button className="point PlayfairDisplay" onClick={event => this.handleClick(event, 'stats', 'sales')}>Продажи</button>
                        <button className="point PlayfairDisplay" onClick={event => this.handleClick(event, 'stats', 'users')}>Пользователи</button>
                    </details>      
                    <details className="reports">
                        <summary className="PlayfairDisplay">Отчётность</summary>
                        <button className="point PlayfairDisplay" onClick={event => this.handleClick(event, 'report', 'xlsx')}>XLSX отчёт</button>
                        <button className="point PlayfairDisplay" onClick={event => this.handleClick(event, 'report', 'backup')}>Резервное копирование</button>
                    </details>
                </aside>      

                {this.renderContent()}
{/* 
                <Table table='user' params={{
                    min_registration_date: '',
                    max_registration_date: '',
                    min_personal_stock: '',
                    max_personal_stock: '',
                    firstname: '',
                    lastname: '',
                    emailname: '',
                    gender: ''
                }}/>           */}
            </div>
        )
    }
}

export default Admin

