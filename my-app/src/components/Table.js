import React, {Component} from "react"
import getCookie from "./Cookies"

class Table extends Component {
    constructor(props){
        super(props)

        this.state = {
            data: null
        }
    }

    componentDidMount(){
        fetch('http://localhost/Bijouterie/backend/api/' + this.props.table + '/?' + new URLSearchParams(this.props.params), {
            method: 'GET',
            credentials: 'include',
            headers: {
                Authorization: getCookie('jwt')
            }
        })
        .then(res => res.json())
        .then(
            (result) => {
                this.setState({
                    is_loaded: true,
                    data: result.data,   
                })        
            },
            (error) => {
                this.setState({
                    is_loaded: true,
                    error
                })
            }
        )
    }

    changeRecord(){
        fetch()
        alert('change')
    }

    deleteRecord(){
        alert('delete')
    }

    renderTable(){
        if (this.state.data?.length > 0){
            return (
                <table className="db-table">
                    <tr>
                        {this.renderRow(Object.keys(this.state.data[0]), 'th')}
                        <td>&nbsp;</td>
                    </tr>
                    {this.state.data.map(record => (
                        <tr key={record.id}>
                            {this.renderRow(Object.values(record))}
                            <td>
                                <button onClick={this.changeRecord}>✏️</button>
                                <button onClick={this.deleteRecord}>❌</button>
                            </td>
                        </tr>        
                    ))}
                </table>
            )
        } else {
            return (
                <div>Нет данных</div>
            )
        }
    }

    renderRow(row, tag = 'td'){
        return (
            row.map(value => (
                tag == 'td' ? <td>{value}</td> : <th>{value}</th>
            ))
        )
    }

    render(){
        return (
            <div className="container">
                {this.renderTable()}
            </div>

        )
    }
}

export default Table