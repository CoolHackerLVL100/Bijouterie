import React, {Component} from "react"
import getCookie from "./Cookies"
import Plot from 'react-plotly.js';

class Stats extends Component {
    constructor(props){
        super(props)

        this.state = {
            data: null
        }
    }

    componentDidMount(){
        fetch('http://localhost/Bijouterie/backend/api/order/', {
            method: 'GET',
            credentials: 'include',
            headers: {
                Authorization: getCookie('jwt')
            }
        })        
        .then(res => res.json())
        .then(
            (result) => {
               
                console.log(result)
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

    render(){
        return (
            <div className="container">
                <Plot
                    data={[
                    {
                        x: this.state.data?.map(obj => obj.month),
                        y: this.state.data?.map(obj => obj.count),
                        type: 'scatter',
                        marker: {color: 'red'},
                    },
                    ]}
                    layout={ {width: 1080, height: 720, title: 'Продажи'} }
                />
            </div>
        )
    }
    
}

export default Stats