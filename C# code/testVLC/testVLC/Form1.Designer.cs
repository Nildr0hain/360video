namespace testVLC
{
    partial class Form1
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(Form1));
            this.vlcplugin = new AxAXVLC.AxVLCPlugin();
            this.button1 = new System.Windows.Forms.Button();
            this.label1 = new System.Windows.Forms.Label();
            this.ipAC = new IPAddressControlLib.IPAddressControl();
            this.btnStop = new System.Windows.Forms.Button();
            this.label2 = new System.Windows.Forms.Label();
            this.txtPort = new System.Windows.Forms.TextBox();
            ((System.ComponentModel.ISupportInitialize)(this.vlcplugin)).BeginInit();
            this.SuspendLayout();
            // 
            // vlcplugin
            // 
            this.vlcplugin.Enabled = true;
            this.vlcplugin.Location = new System.Drawing.Point(12, 12);
            this.vlcplugin.Name = "vlcplugin";
            this.vlcplugin.OcxState = ((System.Windows.Forms.AxHost.State)(resources.GetObject("vlcplugin.OcxState")));
            this.vlcplugin.Size = new System.Drawing.Size(1123, 541);
            this.vlcplugin.TabIndex = 0;
            // 
            // button1
            // 
            this.button1.Location = new System.Drawing.Point(15, 605);
            this.button1.Name = "button1";
            this.button1.Size = new System.Drawing.Size(106, 31);
            this.button1.TabIndex = 1;
            this.button1.Text = "Start stream";
            this.button1.UseVisualStyleBackColor = true;
            this.button1.Click += new System.EventHandler(this.button1_Click);
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(137, 614);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(60, 13);
            this.label1.TabIndex = 3;
            this.label1.Text = "IP address:";
            // 
            // ipAC
            // 
            this.ipAC.AllowInternalTab = false;
            this.ipAC.AutoHeight = true;
            this.ipAC.BackColor = System.Drawing.SystemColors.Window;
            this.ipAC.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D;
            this.ipAC.Cursor = System.Windows.Forms.Cursors.IBeam;
            this.ipAC.Location = new System.Drawing.Point(203, 611);
            this.ipAC.MinimumSize = new System.Drawing.Size(87, 20);
            this.ipAC.Name = "ipAC";
            this.ipAC.ReadOnly = false;
            this.ipAC.Size = new System.Drawing.Size(87, 20);
            this.ipAC.TabIndex = 4;
            this.ipAC.Text = "192.168.1.26";
            // 
            // btnStop
            // 
            this.btnStop.Location = new System.Drawing.Point(15, 571);
            this.btnStop.Name = "btnStop";
            this.btnStop.Size = new System.Drawing.Size(106, 28);
            this.btnStop.TabIndex = 5;
            this.btnStop.Text = "Stop stream";
            this.btnStop.UseVisualStyleBackColor = true;
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(137, 579);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(29, 13);
            this.label2.TabIndex = 6;
            this.label2.Text = "Port:";
            // 
            // txtPort
            // 
            this.txtPort.Location = new System.Drawing.Point(203, 576);
            this.txtPort.Name = "txtPort";
            this.txtPort.Size = new System.Drawing.Size(87, 20);
            this.txtPort.TabIndex = 7;
            this.txtPort.Text = "8090";
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1147, 648);
            this.Controls.Add(this.txtPort);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.btnStop);
            this.Controls.Add(this.ipAC);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.button1);
            this.Controls.Add(this.vlcplugin);
            this.Name = "Form1";
            this.Text = "Form1";
            ((System.ComponentModel.ISupportInitialize)(this.vlcplugin)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private AxAXVLC.AxVLCPlugin vlcplugin;
        private System.Windows.Forms.Button button1;
        private System.Windows.Forms.Label label1;
        private IPAddressControlLib.IPAddressControl ipAC;
        private System.Windows.Forms.Button btnStop;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.TextBox txtPort;
    }
}

