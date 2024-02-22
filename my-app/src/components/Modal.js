import React, {Component} from "react"
import '../css/Modal.css'

class Modal extends Component {
    constructor(props){
        super(props)

        this.state = {
            close: '',
            backward: '',
            forward: ''
        }
    }

    componentDidMount(){
     
    }

    render(){
        return (
            <div className="modal">
                <div className="modal-bg"></div>
                <div className="modal-window">
                    <img src={"http://localhost/Bijouterie/backend/api/image/gallery/" + this.props.image} />
                    <div className="modal-controls">
                        <button 
                            className="icons" 
                            onClick={this.props.onClose}
                            dangerouslySetInnerHTML={{__html: this.props.icons.close}}
                        ></button>
                        <button 
                            className="icons" 
                            onClick={this.props.onBackward}
                            dangerouslySetInnerHTML={{__html: this.props.icons.backward}}
                        ></button>
                        <button 
                            className="icons" 
                            onClick={this.props.onForward}
                            dangerouslySetInnerHTML={{__html: this.props.icons.forward}}
                        ></button>
                    </div>  
                </div>
            </div>    
        )
    }
}

export default Modal

