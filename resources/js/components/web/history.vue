<template>
    <div >
        <el-row>
            <el-col :sm="12" :lg="6">
                <el-result icon="success" title="Thành công" subTitle="Lịch sử hoàn thành event">
                </el-result>
            </el-col>
        </el-row>
        <el-row :gutter="10">
            <el-col :span="24" :md="8" v-for="item in tableData">
                <el-card shadow="hover" class="box-card mb-2" >
                    <div slot="header" class="clearfix">
                        <span>{{item.taskName}}</span>
                    </div>
                    <div v-for="detail in item.eventDetail" class="text item mb-1">
                        <el-alert v-if="detail.active == 2"
                                  :closable="false"
                                  :title="detail.name"
                                  type="success"
                                  show-icon>
                        </el-alert>
                        <el-alert
                            v-if="detail.active == 1"
                            :closable="false"
                            :title="detail.name"
                            type="info"
                            show-icon>
                        </el-alert>
                    </div>
                </el-card>
            </el-col>
        </el-row>
    </div>
</template>

<script>
import {Notification} from "element-ui";
import 'element-tiptap/lib/index.css';
import {ElementTiptap} from 'element-tiptap';
import {
    Doc,
    Text,
    Paragraph,
    Heading,
    Bold,
    Underline,
    Italic,
    Strike,
    ListItem,
    BulletList,
    OrderedList,
    Image,
    TodoList,
    TodoItem,
    Iframe,
    Table,
    TableHeader,
    TableRow,
    TableCell,
    TextAlign,
    LineHeight,
    Indent,
    HorizontalRule,
    HardBreak,
    TrailingNode,
    History,
    TextColor,
    TextHighlight,
    FormatClear,
    FontType,
    FontSize,
    Preview,
    CodeView,
    Print,
    Fullscreen,
    SelectAll,
} from 'element-tiptap';
import moment from "moment";

export default {
    name: "history",
    data() {
        return {
            tableData:[],
        }
    },
    methods:{
        list_data() {
            let url = '/events/history/list'
            axios.get(url).then(e => {
                this.tableData = e.data.message;
                console.log(this.tableData)
            }).catch((_) => {
                loading.close();
            })
        },
    },
    mounted: function () {
        this.list_data()
    },
    filters: {
        moment: function (date) {
            return moment(date).format(' YYYY-MM-DD HH:mm:ss ');
        },
    }
}
</script>

<style scoped>

</style>
